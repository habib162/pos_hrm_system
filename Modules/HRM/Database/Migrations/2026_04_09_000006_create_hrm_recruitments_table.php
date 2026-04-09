<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hrm_recruitments', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->foreignId('department_id')->nullable()->constrained('hrm_departments')->nullOnDelete();
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->unsignedSmallInteger('vacancy_count')->default(1);
            $table->date('deadline')->nullable();
            $table->enum('status', ['open', 'shortlisted', 'interviewed', 'hired', 'rejected', 'closed'])->default('open');
            $table->string('applicant_name')->nullable();
            $table->string('applicant_email')->nullable();
            $table->string('applicant_phone')->nullable();
            $table->string('resume')->nullable();
            $table->dateTime('interview_date')->nullable();
            $table->string('interview_result')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hrm_recruitments');
    }
};
