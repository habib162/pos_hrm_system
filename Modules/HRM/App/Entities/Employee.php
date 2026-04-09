<?php

namespace Modules\HRM\App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $table = 'hrm_employees';

    protected $fillable = [
        'user_id', 'employee_id', 'first_name', 'last_name', 'email', 'phone',
        'gender', 'date_of_birth', 'date_joined', 'department_id', 'designation',
        'employment_type', 'basic_salary', 'address', 'city', 'country',
        'emergency_contact_name', 'emergency_contact_phone',
        'bank_name', 'bank_account', 'status', 'photo',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_joined'   => 'date',
        'basic_salary'  => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class, 'employee_id');
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
