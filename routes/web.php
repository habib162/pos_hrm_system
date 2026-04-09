<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to dashboard or login
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Dashboard — accessible to all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // -------------------------------------------------------------------------
    // POS Module
    // -------------------------------------------------------------------------
    Route::middleware(['permission:pos.view'])->prefix('pos')->name('pos.')->group(function () {
        Route::get('/', fn() => view('pos.index'))->name('index');
        Route::get('/reports', fn() => view('pos.reports'))->name('reports')->middleware('permission:pos.reports');
    });

    Route::middleware(['permission:pos.manage-products'])->prefix('products')->name('products.')->group(function () {
        Route::get('/', fn() => view('pos.products.index'))->name('index');
        Route::get('/create', fn() => view('pos.products.create'))->name('create');
    });

    Route::middleware(['permission:pos.manage-inventory'])->prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', fn() => view('pos.inventory.index'))->name('index');
    });

    Route::middleware(['permission:pos.manage-customers'])->prefix('customers')->name('customers.')->group(function () {
        Route::get('/', fn() => view('pos.customers.index'))->name('index');
        Route::get('/create', fn() => view('pos.customers.create'))->name('create');
    });

    // -------------------------------------------------------------------------
    // HRM Module
    // -------------------------------------------------------------------------
    Route::middleware(['permission:hrm.view'])->prefix('hrm')->name('hrm.')->group(function () {
        Route::get('/reports', fn() => view('hrm.reports'))->name('reports')->middleware('permission:hrm.reports');
    });

    Route::middleware(['permission:hrm.manage-employees'])->prefix('employees')->name('employees.')->group(function () {
        Route::get('/', fn() => view('hrm.employees.index'))->name('index');
        Route::get('/create', fn() => view('hrm.employees.create'))->name('create');
    });

    Route::middleware(['permission:hrm.manage-attendance'])->prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', fn() => view('hrm.attendance.index'))->name('index');
    });

    Route::middleware(['permission:hrm.manage-leaves'])->prefix('leaves')->name('leaves.')->group(function () {
        Route::get('/', fn() => view('hrm.leaves.index'))->name('index');
    });

    Route::middleware(['permission:hrm.manage-payroll'])->prefix('payroll')->name('payroll.')->group(function () {
        Route::get('/', fn() => view('hrm.payroll.index'))->name('index');
    });

    // -------------------------------------------------------------------------
    // System / Admin Module
    // -------------------------------------------------------------------------
    Route::middleware(['permission:system.manage-users'])->prefix('users')->name('users.')->group(function () {
        Route::get('/', fn() => view('system.users.index'))->name('index');
        Route::get('/create', fn() => view('system.users.create'))->name('create');
    });

    Route::middleware(['permission:system.manage-roles'])->prefix('roles')->name('roles.')->group(function () {
        Route::get('/', fn() => view('system.roles.index'))->name('index');
    });

    Route::middleware(['permission:system.settings'])->prefix('settings')->name('settings.')->group(function () {
        Route::get('/', fn() => view('system.settings.index'))->name('index');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__ . '/auth.php';
