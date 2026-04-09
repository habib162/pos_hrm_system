<?php

use Illuminate\Support\Facades\Route;
use Modules\HRM\App\Http\Controllers\EmployeeController;
use Modules\HRM\App\Http\Controllers\DepartmentController;
use Modules\HRM\App\Http\Controllers\AttendanceController;
use Modules\HRM\App\Http\Controllers\LeaveController;
use Modules\HRM\App\Http\Controllers\PayrollController;
use Modules\HRM\App\Http\Controllers\RecruitmentController;

Route::middleware(['auth'])->prefix('hrm')->name('hrm.')->group(function () {

    Route::middleware('permission:hrm.manage-employees')
        ->prefix('employees')->name('employees.')->group(function () {
            Route::get('/', [EmployeeController::class, 'index'])->name('index');
            Route::get('/create', [EmployeeController::class, 'create'])->name('create');
            Route::post('/', [EmployeeController::class, 'store'])->name('store');
            Route::get('/{employee}', [EmployeeController::class, 'show'])->name('show');
            Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
            Route::put('/{employee}', [EmployeeController::class, 'update'])->name('update');
            Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
        });

    Route::middleware('permission:hrm.manage-departments')
        ->prefix('departments')->name('departments.')->group(function () {
            Route::get('/', [DepartmentController::class, 'index'])->name('index');
            Route::get('/create', [DepartmentController::class, 'create'])->name('create');
            Route::post('/', [DepartmentController::class, 'store'])->name('store');
            Route::get('/{department}/edit', [DepartmentController::class, 'edit'])->name('edit');
            Route::put('/{department}', [DepartmentController::class, 'update'])->name('update');
            Route::delete('/{department}', [DepartmentController::class, 'destroy'])->name('destroy');
        });

    Route::middleware('permission:hrm.manage-attendance')
        ->prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/', [AttendanceController::class, 'index'])->name('index');
            Route::post('/', [AttendanceController::class, 'store'])->name('store');
        });

    Route::middleware('permission:hrm.manage-leaves')
        ->prefix('leaves')->name('leaves.')->group(function () {
            Route::get('/', [LeaveController::class, 'index'])->name('index');
            Route::get('/create', [LeaveController::class, 'create'])->name('create');
            Route::post('/', [LeaveController::class, 'store'])->name('store');
            Route::put('/{leave}/approve', [LeaveController::class, 'approve'])->name('approve');
            Route::put('/{leave}/reject', [LeaveController::class, 'reject'])->name('reject');
        });

    Route::middleware('permission:hrm.manage-payroll')
        ->prefix('payroll')->name('payroll.')->group(function () {
            Route::get('/', [PayrollController::class, 'index'])->name('index');
            Route::get('/generate', [PayrollController::class, 'generate'])->name('generate');
            Route::post('/', [PayrollController::class, 'store'])->name('store');
        });

    Route::middleware('permission:hrm.manage-recruitment')
        ->prefix('recruitment')->name('recruitment.')->group(function () {
            Route::get('/', [RecruitmentController::class, 'index'])->name('index');
            Route::get('/create', [RecruitmentController::class, 'create'])->name('create');
            Route::post('/', [RecruitmentController::class, 'store'])->name('store');
            Route::get('/{recruitment}/edit', [RecruitmentController::class, 'edit'])->name('edit');
            Route::put('/{recruitment}', [RecruitmentController::class, 'update'])->name('update');
            Route::delete('/{recruitment}', [RecruitmentController::class, 'destroy'])->name('destroy');
        });

    Route::middleware('permission:hrm.reports')
        ->get('/reports', fn() => view('hrm::reports.index'))->name('reports');
});
