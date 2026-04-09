<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\App\Http\Controllers\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('core.dashboard');
});
