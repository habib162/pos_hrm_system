<?php

namespace Modules\POS\App\Livewire\Customers;

use Livewire\Component;
use Modules\POS\App\Entities\Customer;

class CustomerForm extends Component
{
    public ?int    $customerId   = null;
    public string  $name         = '';
    public string  $email        = '';
    public string  $phone        = '';
    public string  $address      = '';
    public float   $credit_limit = 0;

    protected function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'email'        => 'nullable|email|max:255|unique:pos_customers,email' . ($this->customerId ? ",{$this->customerId}" : ''),
            'phone'        => 'nullable|string|max:30',
            'address'      => 'nullable|string|max:500',
            'credit_limit' => 'nullable|numeric|min:0',
        ];
    }

    public function mount(?int $customerId = null): void
    {
        if ($customerId) {
            $customer             = Customer::findOrFail($customerId);
            $this->customerId     = $customer->id;
            $this->name           = $customer->name;
            $this->email          = $customer->email ?? '';
            $this->phone          = $customer->phone ?? '';
            $this->address        = $customer->address ?? '';
            $this->credit_limit   = (float) $customer->credit_limit;
        }
    }

    public function save(): void
    {
        $data = $this->validate();
        $data['email'] = $this->email ?: null;

        if ($this->customerId) {
            Customer::findOrFail($this->customerId)->update($data);
            $this->dispatch('toast-success', message: 'Customer updated successfully.');
        } else {
            Customer::create($data);
            $this->dispatch('toast-success', message: 'Customer created successfully.');
        }

        $this->redirect(route('pos.customers.index'));
    }

    public function render()
    {
        return view('pos::livewire.customers.customer-form');
    }
}
