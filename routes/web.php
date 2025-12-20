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

    // Inventory routes
    Route::get('/inventory', [WebInventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [WebInventoryController::class, 'create'])->name('inventory.create');
    
    Route::get('/inventory/available-serials', [WebInventoryController::class, 'getAvailableSerials'])->name('inventory.available-serials');
    Route::get('/inventory/returnable-serials', [WebInventoryController::class, 'getReturnableSerials'])->name('inventory.returnable-serials');
    
    Route::post('/inventory', [WebInventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{id}/edit/{type}', [WebInventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}/{type}', [WebInventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}/{type}', [WebInventoryController::class, 'destroy'])->name('inventory.destroy');
});