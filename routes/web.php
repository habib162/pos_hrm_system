<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes — Module routes are auto-loaded by nwidart/laravel-modules
|--------------------------------------------------------------------------
*/

// Redirect root to dashboard
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('core.dashboard')
        : redirect()->route('login');
});

// Redirect old /dashboard route (Breeze default) to module dashboard
Route::get('/dashboard', function () {
    return redirect()->route('core.dashboard');
})->middleware(['auth'])->name('dashboard');

// Profile (Breeze default)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
