<?php

namespace Modules\POS\App\Livewire\Sales;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\POS\App\Entities\Product;
use Modules\POS\App\Entities\Sale;

class SaleList extends Component
{
    use WithPagination;

    public string  $search        = '';
    public string  $dateFrom      = '';
    public string  $dateTo        = '';
    public string  $methodFilter  = '';
    public string  $statusFilter  = '';
    public ?Sale   $viewingSale   = null;
    public ?int    $confirmRefund = null;

    protected $queryString = ['search', 'dateFrom', 'dateTo', 'methodFilter', 'statusFilter'];

    public function updatingSearch(): void { $this->resetPage(); }

    public function viewSale(int $id): void
    {
        $this->viewingSale = Sale::with('saleItems', 'customer', 'user')->findOrFail($id);
    }

    public function closeSaleModal(): void
    {
        $this->viewingSale = null;
    }

    public function confirmRefundSale(int $id): void
    {
        $this->confirmRefund = $id;
    }

    public function refundSale(): void
    {
        if (! $this->confirmRefund) {
            return;
        }

        $sale = Sale::with('saleItems')->findOrFail($this->confirmRefund);

        if ($sale->status === 'refunded') {
            $this->dispatch('toast-error', message: 'Sale already refunded.');
            $this->confirmRefund = null;
            return;
        }

        $sale->update(['status' => 'refunded']);

        // Restore stock
        foreach ($sale->saleItems as $item) {
            if ($item->product_id) {
                Product::where('id', $item->product_id)->increment('stock', $item->quantity);
            }
        }

        $this->confirmRefund = null;
        $this->viewingSale   = null;
        $this->dispatch('toast-success', message: 'Sale refunded and stock restored.');
    }

    public function cancelRefund(): void
    {
        $this->confirmRefund = null;
    }

    public function render()
    {
        $sales = Sale::with('customer', 'user')
            ->when($this->search, fn($q) =>
                $q->where('invoice_no', 'like', "%{$this->search}%")
            )
            ->when($this->dateFrom, fn($q) =>
                $q->whereDate('created_at', '>=', $this->dateFrom)
            )
            ->when($this->dateTo, fn($q) =>
                $q->whereDate('created_at', '<=', $this->dateTo)
            )
            ->when($this->methodFilter, fn($q) =>
                $q->where('payment_method', $this->methodFilter)
            )
            ->when($this->statusFilter, fn($q) =>
                $q->where('status', $this->statusFilter)
            )
            ->orderByDesc('created_at')
            ->paginate((int) setting('items_per_page', 15));

        $todayTotal    = Sale::today()->completed()->sum('total');
        $todayCount    = Sale::today()->completed()->count();

        return view('pos::livewire.sales.sale-list', compact('sales', 'todayTotal', 'todayCount'));
    }
}
