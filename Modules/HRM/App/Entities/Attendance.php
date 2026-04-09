<?php

namespace Modules\HRM\App\Entities;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'hrm_attendances';

    protected $fillable = [
        'employee_id', 'date', 'check_in', 'check_out',
        'working_hours', 'overtime_hours', 'status', 'notes',
    ];

    protected $casts = [
        'date'           => 'date',
        'check_in'       => 'datetime',
        'check_out'      => 'datetime',
        'working_hours'  => 'decimal:2',
        'overtime_hours' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }
}
