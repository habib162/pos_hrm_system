<?php

namespace Modules\POS\App\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\POS\App\Entities\Category;
use Modules\POS\App\Entities\Product;

class ProductList extends Component
{
    use WithPagination;

    public string $search         = '';
    public string $categoryFilter = '';
    public string $statusFilter   = '';
    public ?int   $confirmDelete  = null;

    protected $queryString = ['search', 'categoryFilter', 'statusFilter'];

    public function updatingSearch(): void   { $this->resetPage(); }
    public function updatingCategoryFilter(): void { $this->resetPage(); }

    public function toggleActive(int $id): void
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => ! $product->is_active]);
        $this->dispatch('toast-success', message: 'Product status updated.');
    }

    public function confirmDeleteProduct(int $id): void
    {
        $this->confirmDelete = $id;
    }

    public function deleteProduct(): void
    {
        if ($this->confirmDelete) {
            Product::destroy($this->confirmDelete);
            $this->confirmDelete = null;
            $this->dispatch('toast-success', message: 'Product deleted.');
        }
    }

    public function cancelDelete(): void
    {
        $this->confirmDelete = null;
    }

    public function render()
    {
        $perPage = (int) setting('items_per_page', 15);

        $products = Product::with('category')
            ->when($this->search, fn($q) =>
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('sku', 'like', "%{$this->search}%")
            )
            ->when($this->categoryFilter, fn($q) =>
                $q->where('category_id', $this->categoryFilter)
            )
            ->when($this->statusFilter !== '', fn($q) =>
                $q->where('is_active', $this->statusFilter === '1')
            )
            ->orderBy('name')
            ->paginate($perPage);

        $categories = Category::active()->orderBy('name')->get();

        return view('pos::livewire.products.product-list', compact('products', 'categories'));
    }
}
