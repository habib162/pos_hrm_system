<?php

namespace Modules\POS\App\Livewire\Categories;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\POS\App\Entities\Category;

class CategoryList extends Component
{
    use WithPagination;

    public string $search        = '';
    public ?int   $confirmDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch(): void { $this->resetPage(); }

    public function confirmDeleteCategory(int $id): void
    {
        $this->confirmDelete = $id;
    }

    public function deleteCategory(): void
    {
        if ($this->confirmDelete) {
            Category::destroy($this->confirmDelete);
            $this->confirmDelete = null;
            $this->dispatch('toast-success', message: 'Category deleted.');
        }
    }

    public function cancelDelete(): void
    {
        $this->confirmDelete = null;
    }

    public function render()
    {
        $categories = Category::withCount('products')
            ->when($this->search, fn($q) =>
                $q->where('name', 'like', "%{$this->search}%")
            )
            ->orderBy('name')
            ->paginate((int) setting('items_per_page', 15));

        return view('pos::livewire.categories.category-list', compact('categories'));
    }
}
