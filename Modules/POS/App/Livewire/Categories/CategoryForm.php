<?php

namespace Modules\POS\App\Livewire\Categories;

use Livewire\Component;
use Illuminate\Support\Str;
use Modules\POS\App\Entities\Category;

class CategoryForm extends Component
{
    public ?int    $categoryId  = null;
    public string  $name        = '';
    public string  $description = '';
    public bool    $is_active   = true;

    protected function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active'   => 'boolean',
        ];
    }

    public function mount(?int $categoryId = null): void
    {
        if ($categoryId) {
            $category            = Category::findOrFail($categoryId);
            $this->categoryId    = $category->id;
            $this->name          = $category->name;
            $this->description   = $category->description ?? '';
            $this->is_active     = $category->is_active;
        }
    }

    public function save(): void
    {
        $data = $this->validate();
        $data['slug'] = Str::slug($this->name);

        if ($this->categoryId) {
            Category::findOrFail($this->categoryId)->update($data);
            $this->dispatch('toast-success', message: 'Category updated successfully.');
        } else {
            Category::create($data);
            $this->dispatch('toast-success', message: 'Category created successfully.');
        }

        $this->redirect(route('pos.categories.index'));
    }

    public function render()
    {
        return view('pos::livewire.categories.category-form');
    }
}
