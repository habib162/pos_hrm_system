<?php

namespace Modules\HRM\App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruitment extends Model
{
    use SoftDeletes;

    protected $table = 'hrm_recruitments';

    protected $fillable = [
        'job_title', 'department_id', 'description', 'requirements',
        'vacancy_count', 'deadline', 'status',
        'applicant_name', 'applicant_email', 'applicant_phone',
        'resume', 'interview_date', 'interview_result', 'notes',
    ];

    protected $casts = [
        'deadline'       => 'date',
        'interview_date' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
