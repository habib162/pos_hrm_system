<?php

namespace Modules\POS\App\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Modules\POS\App\Entities\Category;
use Modules\POS\App\Entities\Product;

class ProductForm extends Component
{
    use WithFileUploads;

    public ?int    $productId      = null;
    public string  $name           = '';
    public string  $sku            = '';
    public string  $barcode        = '';
    public ?int    $category_id    = null;
    public string  $description    = '';
    public float   $purchase_price = 0;
    public float   $sale_price     = 0;
    public int     $stock          = 0;
    public int     $alert_quantity = 10;
    public string  $type           = 'standard';
    public string  $unit           = 'pcs';
    public bool    $is_active      = true;
    public         $image          = null;
    public ?string $currentImage   = null;

    protected function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'sku'            => 'required|string|max:100|unique:pos_products,sku' . ($this->productId ? ",{$this->productId}" : ''),
            'category_id'    => 'nullable|exists:pos_categories,id',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price'     => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'alert_quantity' => 'required|integer|min:0',
            'type'           => 'required|in:standard,variant',
            'unit'           => 'required|string|max:50',
            'is_active'      => 'boolean',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function mount(?int $productId = null): void
    {
        if ($productId) {
            $product             = Product::findOrFail($productId);
            $this->productId     = $product->id;
            $this->name          = $product->name;
            $this->sku           = $product->sku;
            $this->barcode       = $product->barcode ?? '';
            $this->category_id   = $product->category_id;
            $this->description   = $product->description ?? '';
            $this->purchase_price = (float) $product->purchase_price;
            $this->sale_price    = (float) $product->sale_price;
            $this->stock         = $product->stock;
            $this->alert_quantity = $product->alert_quantity;
            $this->type          = $product->type;
            $this->unit          = $product->unit;
            $this->is_active     = $product->is_active;
            $this->currentImage  = $product->image;
        }
    }

    public function updatedName(): void
    {
        if (! $this->productId) {
            $this->sku = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $this->name), 0, 3))
                       . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->image) {
            Storage::disk('public')->makeDirectory('products');
            $data['image'] = $this->image->store('products', 'public');
        } else {
            unset($data['image']);
        }

        $data['slug']   = Str::slug($this->name);
        $data['barcode'] = $this->barcode ?: null;

        if ($this->productId) {
            $product = Product::findOrFail($this->productId);
            if ($this->image && $product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->update($data);
            $this->dispatch('toast-success', message: 'Product updated successfully.');
        } else {
            Product::create($data);
            $this->dispatch('toast-success', message: 'Product created successfully.');
        }

        $this->redirect(route('pos.products.index'));
    }

    public function render()
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('pos::livewire.products.product-form', compact('categories'));
    }
}
