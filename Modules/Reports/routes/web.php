<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\App\Http\Controllers\ReportController;

Route::middleware(['auth'])->prefix('reports')->name('reports.')->group(function () {
    Route::middleware('permission:pos.reports')
        ->get('/pos', [ReportController::class, 'posReport'])->name('pos');

    Route::middleware('permission:hrm.reports')
        ->get('/hrm', [ReportController::class, 'hrmReport'])->name('hrm');
});
