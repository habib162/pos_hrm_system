<?php

namespace Modules\POS\App\Livewire;

use Livewire\Component;
use Modules\POS\App\Entities\Customer;
use Modules\POS\App\Entities\Payment;
use Modules\POS\App\Entities\Product;
use Modules\POS\App\Entities\Sale;
use Modules\POS\App\Entities\SaleItem;

class POSScreen extends Component
{
    public array  $cart             = [];
    public string $search           = '';
    public array  $products         = [];
    public array  $categories       = [];
    public ?int   $filterCategory   = null;
    public ?int   $selectedCustomerId = null;
    public string $customerSearch   = '';
    public array  $customerResults  = [];
    public float  $discount         = 0;
    public float  $amountPaid       = 0;
    public string $paymentMethod    = 'cash';
    public string $note             = '';
    public bool   $showPaymentModal = false;
    public bool   $showReceiptModal = false;
    public ?Sale  $lastSale         = null;

    public function mount(): void
    {
        $this->loadProducts();
        $this->categories = \Modules\POS\App\Entities\Category::active()->orderBy('name')->get()->toArray();
    }

    private function loadProducts(): void
    {
        $query = Product::active()->with('category');

        if ($this->filterCategory) {
            $query->where('category_id', $this->filterCategory);
        }

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('sku', 'like', "%{$this->search}%")
                  ->orWhere('barcode', $this->search);
            });
        }

        $this->products = $query->orderBy('name')->limit(80)->get()->toArray();
    }

    public function updatedSearch(): void
    {
        $this->loadProducts();
    }

    public function filterByCategory(?int $id): void
    {
        $this->filterCategory = $id;
        $this->loadProducts();
    }

    public function addToCart(int $productId): void
    {
        $product = Product::find($productId);
        if (! $product || ! $product->is_active) {
            return;
        }

        foreach ($this->cart as $i => $item) {
            if ($item['product_id'] === $productId) {
                $newQty = $item['qty'] + 1;
                if ($newQty > $product->stock) {
                    $this->dispatch('toast-error', message: 'Not enough stock!');
                    return;
                }
                $this->cart[$i]['qty']      = $newQty;
                $this->cart[$i]['subtotal'] = round($newQty * $item['unit_price'] - $item['discount'], 2);
                return;
            }
        }

        if ($product->stock < 1) {
            $this->dispatch('toast-error', message: 'Product out of stock!');
            return;
        }

        $this->cart[] = [
            'product_id'   => $product->id,
            'name'         => $product->name,
            'unit_price'   => (float) $product->sale_price,
            'qty'          => 1,
            'discount'     => 0.0,
            'subtotal'     => (float) $product->sale_price,
            'stock'        => $product->stock,
            'is_low_stock' => $product->is_low_stock,
        ];
    }

    public function removeFromCart(int $index): void
    {
        array_splice($this->cart, $index, 1);
        $this->cart = array_values($this->cart);
    }

    public function updateQty(int $index, int $qty): void
    {
        if ($qty < 1) {
            $this->removeFromCart($index);
            return;
        }
        if ($qty > $this->cart[$index]['stock']) {
            $this->dispatch('toast-error', message: 'Exceeds available stock!');
            return;
        }
        $this->cart[$index]['qty']      = $qty;
        $this->cart[$index]['subtotal'] = round(
            $qty * $this->cart[$index]['unit_price'] - $this->cart[$index]['discount'],
            2
        );
    }

    public function updateDiscount(int $index, float $discount): void
    {
        $maxDiscount = $this->cart[$index]['qty'] * $this->cart[$index]['unit_price'];
        $discount    = min(max($discount, 0), $maxDiscount);
        $this->cart[$index]['discount'] = $discount;
        $this->cart[$index]['subtotal'] = round(
            $this->cart[$index]['qty'] * $this->cart[$index]['unit_price'] - $discount,
            2
        );
    }

    public function getSubtotalProperty(): float
    {
        return round(array_sum(array_column($this->cart, 'subtotal')), 2);
    }

    public function getTaxProperty(): float
    {
        $rate = (float) setting('tax_percentage', 0);
        return round($this->subtotal * $rate / 100, 2);
    }

    public function getDiscountTotalProperty(): float
    {
        $itemDiscounts = array_sum(array_column($this->cart, 'discount'));
        return round($itemDiscounts + $this->discount, 2);
    }

    public function getTotalProperty(): float
    {
        return round($this->subtotal + $this->tax - (float) $this->discount, 2);
    }

    public function getChangeProperty(): float
    {
        return round($this->amountPaid - $this->total, 2);
    }

    public function searchCustomer(): void
    {
        if (strlen($this->customerSearch) < 2) {
            $this->customerResults = [];
            return;
        }
        $this->customerResults = Customer::where('name', 'like', "%{$this->customerSearch}%")
            ->orWhere('phone', 'like', "%{$this->customerSearch}%")
            ->limit(8)->get()->toArray();
    }

    public function selectCustomer(int $id): void
    {
        $customer                = Customer::find($id);
        $this->selectedCustomerId = $id;
        $this->customerSearch    = $customer->name;
        $this->customerResults   = [];
    }

    public function clearCustomer(): void
    {
        $this->selectedCustomerId = null;
        $this->customerSearch     = '';
        $this->customerResults    = [];
    }

    public function openPaymentModal(): void
    {
        if (empty($this->cart)) {
            return;
        }
        $this->amountPaid      = $this->total;
        $this->showPaymentModal = true;
    }

    public function clearCart(): void
    {
        $this->cart              = [];
        $this->discount          = 0;
        $this->amountPaid        = 0;
        $this->note              = '';
        $this->paymentMethod     = 'cash';
        $this->selectedCustomerId = null;
        $this->customerSearch    = '';
        $this->showPaymentModal  = false;
        $this->showReceiptModal  = false;
        $this->lastSale          = null;
    }

    public function checkout(): void
    {
        if (empty($this->cart)) {
            return;
        }

        $this->validate([
            'amountPaid'    => 'required|numeric|min:' . $this->total,
            'paymentMethod' => 'required|in:cash,card,mobile,split',
        ]);

        $sale = Sale::create([
            'invoice_no'     => Sale::generateInvoiceNo(),
            'customer_id'    => $this->selectedCustomerId,
            'user_id'        => auth()->id(),
            'subtotal'       => $this->subtotal,
            'discount'       => $this->discountTotal,
            'tax'            => $this->tax,
            'total'          => $this->total,
            'paid'           => $this->amountPaid,
            'change'         => $this->change,
            'payment_method' => $this->paymentMethod,
            'status'         => 'completed',
            'note'           => $this->note,
        ]);

        foreach ($this->cart as $item) {
            SaleItem::create([
                'sale_id'      => $sale->id,
                'product_id'   => $item['product_id'],
                'product_name' => $item['name'],
                'quantity'     => $item['qty'],
                'unit_price'   => $item['unit_price'],
                'discount'     => $item['discount'],
                'subtotal'     => $item['subtotal'],
            ]);

            Product::where('id', $item['product_id'])->decrement('stock', $item['qty']);
        }

        Payment::create([
            'sale_id' => $sale->id,
            'amount'  => $this->amountPaid,
            'method'  => $this->paymentMethod,
        ]);

        if ($this->selectedCustomerId) {
            $customer = Customer::find($this->selectedCustomerId);
            $customer?->addPoints($this->total);
        }

        $this->lastSale         = $sale->load('saleItems', 'customer', 'user');
        $this->showPaymentModal = false;
        $this->showReceiptModal = true;
        $this->loadProducts();
    }

    public function printReceipt(): void
    {
        $this->dispatch('print-receipt');
    }

    public function closeReceipt(): void
    {
        $this->clearCart();
        $this->loadProducts();
    }

    public function render()
    {
        return view('pos::livewire.pos-screen')
            ->layout('core::layouts.app')
            ->title('POS Terminal');
    }
}
