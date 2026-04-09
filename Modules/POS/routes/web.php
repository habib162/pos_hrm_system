<?php

use Illuminate\Support\Facades\Route;
use Modules\POS\App\Http\Controllers\POSTerminalController;
use Modules\POS\App\Http\Controllers\ProductController;
use Modules\POS\App\Http\Controllers\CategoryController;
use Modules\POS\App\Http\Controllers\CustomerController;
use Modules\POS\App\Http\Controllers\SaleController;

Route::middleware(['auth'])->group(function () {

    // POS Terminal — cashier and above
    Route::middleware('role:super-admin|manager|cashier')
        ->get('/pos', POSTerminalController::class)
        ->name('pos.index');

    // Products, Categories, Customers, Sales — manager and above
    Route::middleware('role:super-admin|manager')->group(function () {

        Route::prefix('pos/products')->name('pos.products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        });

        Route::prefix('pos/categories')->name('pos.categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        });

        Route::prefix('pos/customers')->name('pos.customers.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/create', [CustomerController::class, 'create'])->name('create');
            Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
        });

        Route::prefix('pos/sales')->name('pos.sales.')->group(function () {
            Route::get('/', [SaleController::class, 'index'])->name('index');
        });
    });
});
