<?php

namespace Modules\Core\App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public array $posStats = [
        'today_sales'      => 0,
        'transactions'     => 0,
        'total_products'   => 0,
        'low_stock'        => 0,
        'customers'        => 0,
        'monthly_revenue'  => 0,
    ];

    public array $hrmStats = [
        'total_employees' => 0,
        'present_today'   => 0,
        'on_leave'        => 0,
        'pending_leaves'  => 0,
        'payroll_month'   => 0,
    ];

    public function mount(): void
    {
        $this->loadStats();
    }

    private function loadStats(): void
    {
        // POS stats will be populated when POS module entities exist
        // $this->posStats['today_sales'] = Sale::today()->sum('total');

        // HRM stats will be populated when HRM module entities exist
        // $this->hrmStats['total_employees'] = Employee::active()->count();
    }

    public function render()
    {
        return view('core::livewire.dashboard');
    }
}
