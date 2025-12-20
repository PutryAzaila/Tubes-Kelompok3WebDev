<?php

use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WebInventoryController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

// Protected Routes (butuh login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Inventory Routes
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [WebInventoryController::class, 'index'])->name('index');
        Route::get('/create', [WebInventoryController::class, 'create'])->name('create');
        Route::post('/', [WebInventoryController::class, 'store'])->name('store');
        Route::get('/{id}/{type}/edit', [WebInventoryController::class, 'edit'])->name('edit');
        Route::put('/{id}/{type}', [WebInventoryController::class, 'update'])->name('update');
        Route::delete('/{id}/{type}', [WebInventoryController::class, 'destroy'])->name('destroy');
    });
});