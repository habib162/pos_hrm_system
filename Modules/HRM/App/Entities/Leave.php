<?php

namespace Modules\HRM\App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table = 'hrm_leaves';

    protected $fillable = [
        'employee_id', 'leave_type', 'start_date', 'end_date',
        'total_days', 'reason', 'status', 'approved_by', 'approved_at', 'remarks',
    ];

    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'approved_at' => 'datetime',
        'total_days'  => 'decimal:1',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
