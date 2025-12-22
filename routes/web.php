<?php

use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WebInventoryController;
use App\Http\Controllers\WebKategoriVendorController;
use App\Http\Controllers\WebKategoriPerangkatController; // TAMBAHAN BARU
use App\Http\Controllers\WebPerangkatController;
use App\Http\Controllers\WebVendorController; 
use App\Http\Controllers\WebProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Vendor routes (WebVendorController)
    Route::get('/vendor', [WebVendorController::class, 'index'])->name('vendor.index');
    Route::get('/vendor/create', [WebVendorController::class, 'create'])->name('vendor.create');
    Route::post('/vendor', [WebVendorController::class, 'store'])->name('vendor.store');
    Route::get('/vendor/{id}/edit', [WebVendorController::class, 'edit'])->name('vendor.edit');
    Route::put('/vendor/{id}', [WebVendorController::class, 'update'])->name('vendor.update');
    Route::delete('/vendor/{id}', [WebVendorController::class, 'destroy'])->name('vendor.destroy');

    // Inventory routes
    Route::get('/inventory', [WebInventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [WebInventoryController::class, 'create'])->name('inventory.create');
    Route::get('/inventory/available-serials', [WebInventoryController::class, 'getAvailableSerials'])->name('inventory.available-serials');
    Route::get('/inventory/returnable-serials', [WebInventoryController::class, 'getReturnableSerials'])->name('inventory.returnable-serials');
    Route::post('/inventory', [WebInventoryController::class, 'store'])->name('inventory.store');    
    Route::get('/inventory/{id}/edit/{type}', [WebInventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}/{type}', [WebInventoryController::class, 'update'])->name('inventory.update');

    // Kategori Vendor routes
    Route::get('/kategori-vendor', [WebKategoriVendorController::class, 'index'])->name('kategori-vendor.index');
    Route::get('/kategori-vendor/create', [WebKategoriVendorController::class, 'create'])->name('kategori-vendor.create');
    Route::post('/kategori-vendor', [WebKategoriVendorController::class, 'store'])->name('kategori-vendor.store');
    Route::get('/kategori-vendor/{id}/edit', [WebKategoriVendorController::class, 'edit'])->name('kategori-vendor.edit');
    Route::put('/kategori-vendor/{id}', [WebKategoriVendorController::class, 'update'])->name('kategori-vendor.update');
    Route::delete('/kategori-vendor/{id}', [WebKategoriVendorController::class, 'destroy'])->name('kategori-vendor.destroy');

    // ==================== KATEGORI PERANGKAT ROUTES (BARU) ====================
    Route::get('/kategori-perangkat', [WebKategoriPerangkatController::class, 'index'])->name('kategori-perangkat.index');
    Route::get('/kategori-perangkat/create', [WebKategoriPerangkatController::class, 'create'])->name('kategori-perangkat.create');
    Route::post('/kategori-perangkat', [WebKategoriPerangkatController::class, 'store'])->name('kategori-perangkat.store');
    Route::get('/kategori-perangkat/{id}/edit', [WebKategoriPerangkatController::class, 'edit'])->name('kategori-perangkat.edit');
    Route::put('/kategori-perangkat/{id}', [WebKategoriPerangkatController::class, 'update'])->name('kategori-perangkat.update');
    Route::delete('/kategori-perangkat/{id}', [WebKategoriPerangkatController::class, 'destroy'])->name('kategori-perangkat.destroy');
    // ==========================================================================

    // Perangkat routes (Index dengan Modal Detail + Create + Edit + Delete)
    Route::get('/perangkat', [WebPerangkatController::class, 'index'])->name('perangkat.index');
    Route::get('/perangkat/create', [WebPerangkatController::class, 'create'])->name('perangkat.create');
    Route::post('/perangkat', [WebPerangkatController::class, 'store'])->name('perangkat.store');
    Route::get('/perangkat/{id}/edit', [WebPerangkatController::class, 'edit'])->name('perangkat.edit');
    Route::put('/perangkat/{id}', [WebPerangkatController::class, 'update'])->name('perangkat.update');
    Route::delete('/perangkat/{id}', [WebPerangkatController::class, 'destroy'])->name('perangkat.destroy');
    
    // Additional Perangkat routes
    Route::get('/perangkat-statistics', [WebPerangkatController::class, 'statistics'])->name('perangkat.statistics');
    Route::get('/perangkat-export', [WebPerangkatController::class, 'export'])->name('perangkat.export');

    // Profile Routes
    Route::get('/profile', [WebProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [WebProfileController::class, 'update'])->name('profile.update');
    
    // Tambahkan route alias untuk kompatibilitas dengan view
    Route::put('/profile/password', [WebProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::put('/profile/update-password', [WebProfileController::class, 'updatePassword'])->name('profile.password.update');
});