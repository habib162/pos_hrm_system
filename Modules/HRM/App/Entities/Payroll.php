<?php

namespace Modules\HRM\App\Entities;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'hrm_payrolls';

    protected $fillable = [
        'employee_id', 'month', 'year',
        'basic_salary', 'allowances', 'overtime_pay', 'bonuses',
        'deductions', 'tax', 'net_salary',
        'payment_date', 'payment_method', 'status', 'notes',
    ];

    protected $casts = [
        'basic_salary'   => 'decimal:2',
        'allowances'     => 'decimal:2',
        'overtime_pay'   => 'decimal:2',
        'bonuses'        => 'decimal:2',
        'deductions'     => 'decimal:2',
        'tax'            => 'decimal:2',
        'net_salary'     => 'decimal:2',
        'payment_date'   => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function scopeThisMonth($query)
    {
        return $query->where('month', now()->month)->where('year', now()->year);
    }
}
