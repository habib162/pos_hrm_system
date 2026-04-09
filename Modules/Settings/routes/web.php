<?php

use Illuminate\Support\Facades\Route;
use Modules\Settings\App\Http\Controllers\GeneralSettingsController;

Route::middleware(['auth', 'role:super-admin|manager'])
    ->prefix('settings')
    ->name('settings.')
    ->group(function () {
        Route::get('/', GeneralSettingsController::class)->name('index');
    });
