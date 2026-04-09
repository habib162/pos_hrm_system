<?php

namespace Modules\POS\App\Livewire\Customers;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\POS\App\Entities\Customer;

class CustomerList extends Component
{
    use WithPagination;

    public string $search        = '';
    public ?int   $confirmDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch(): void { $this->resetPage(); }

    public function confirmDeleteCustomer(int $id): void
    {
        $this->confirmDelete = $id;
    }

    public function deleteCustomer(): void
    {
        if ($this->confirmDelete) {
            Customer::destroy($this->confirmDelete);
            $this->confirmDelete = null;
            $this->dispatch('toast-success', message: 'Customer deleted.');
        }
    }

    public function cancelDelete(): void
    {
        $this->confirmDelete = null;
    }

    public function render()
    {
        $customers = Customer::withCount('sales')
            ->when($this->search, fn($q) =>
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
            )
            ->orderBy('name')
            ->paginate((int) setting('items_per_page', 15));

        return view('pos::livewire.customers.customer-list', compact('customers'));
    }
}
