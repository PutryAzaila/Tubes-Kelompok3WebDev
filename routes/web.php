<?php

use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WebDashboardController;
use App\Http\Controllers\WebInventoryController;
use App\Http\Controllers\WebKategoriVendorController;
use App\Http\Controllers\WebKategoriPerangkatController;
use App\Http\Controllers\WebPerangkatController;
use App\Http\Controllers\WebVendorController; 
use App\Http\Controllers\WebProfileController;
use App\Http\Controllers\WebPurchaseOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

// ========== SEMUA ROLE - Dashboard & Profile ==========
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [WebDashboardController::class, 'index'])->name('dashboard');
    
   Route::prefix('profile')->middleware(['auth'])->group(function () {
    Route::get('/', [WebProfileController::class, 'index'])
            ->name('profile.index');

        // halaman edit profil (termasuk ganti password)
        Route::get('/edit', [WebProfileController::class, 'edit'])
            ->name('profile.edit');

        // update data profil
        Route::put('/', [WebProfileController::class, 'update'])
            ->name('profile.update');

        // update password (form ada di halaman edit)
        Route::put('/password', [WebProfileController::class, 'updatePassword'])
            ->name('profile.password.update');

});
});

// ========== ADMIN & MANAJER - View Access (Read Only) ==========
Route::middleware(['auth', 'role:admin,manajer'])->group(function () {
    // Vendor - View
    Route::get('/vendor', [WebVendorController::class, 'index'])->name('vendor.index');
    
    // Kategori Vendor - View
    Route::get('/kategori-vendor', [WebKategoriVendorController::class, 'index'])->name('kategori-vendor.index');
    
    // Kategori Perangkat - View
    Route::get('/kategori-perangkat', [WebKategoriPerangkatController::class, 'index'])->name('kategori-perangkat.index');
    
    // Perangkat - View
    Route::get('/perangkat', [WebPerangkatController::class, 'index'])->name('perangkat.index');
});

// ========== MANAJER ONLY - Approval Actions ==========
Route::middleware(['auth', 'role:manajer'])->group(function () {
    // PO - Approve/Reject
    Route::patch('/purchase-order/{id}/approve', [WebPurchaseOrderController::class, 'approve'])->name('purchase-order.approve');
    Route::patch('/purchase-order/{id}/reject', [WebPurchaseOrderController::class, 'reject'])->name('purchase-order.reject');
});

// ========== ADMIN ONLY - Full CRUD ==========
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Vendor - CRUD
    Route::get('/vendor/create', [WebVendorController::class, 'create'])->name('vendor.create');
    Route::post('/vendor', [WebVendorController::class, 'store'])->name('vendor.store');
    Route::get('/vendor/{id}/edit', [WebVendorController::class, 'edit'])->name('vendor.edit');
    Route::put('/vendor/{id}', [WebVendorController::class, 'update'])->name('vendor.update');
    Route::delete('/vendor/{id}', [WebVendorController::class, 'destroy'])->name('vendor.destroy');

    // Kategori Vendor - CRUD
    Route::get('/kategori-vendor/create', [WebKategoriVendorController::class, 'create'])->name('kategori-vendor.create');
    Route::post('/kategori-vendor', [WebKategoriVendorController::class, 'store'])->name('kategori-vendor.store');
    Route::get('/kategori-vendor/{id}/edit', [WebKategoriVendorController::class, 'edit'])->name('kategori-vendor.edit');
    Route::put('/kategori-vendor/{id}', [WebKategoriVendorController::class, 'update'])->name('kategori-vendor.update');
    Route::delete('/kategori-vendor/{id}', [WebKategoriVendorController::class, 'destroy'])->name('kategori-vendor.destroy');

    // Kategori Perangkat - CRUD
    Route::get('/kategori-perangkat/create', [WebKategoriPerangkatController::class, 'create'])->name('kategori-perangkat.create');
    Route::post('/kategori-perangkat', [WebKategoriPerangkatController::class, 'store'])->name('kategori-perangkat.store');
    Route::get('/kategori-perangkat/{id}/edit', [WebKategoriPerangkatController::class, 'edit'])->name('kategori-perangkat.edit');
    Route::put('/kategori-perangkat/{id}', [WebKategoriPerangkatController::class, 'update'])->name('kategori-perangkat.update');
    Route::delete('/kategori-perangkat/{id}', [WebKategoriPerangkatController::class, 'destroy'])->name('kategori-perangkat.destroy');

    // Perangkat - CRUD
    Route::get('/perangkat/create', [WebPerangkatController::class, 'create'])->name('perangkat.create');
    Route::post('/perangkat', [WebPerangkatController::class, 'store'])->name('perangkat.store');
    Route::get('/perangkat/{id}/edit', [WebPerangkatController::class, 'edit'])->name('perangkat.edit');
    Route::put('/perangkat/{id}', [WebPerangkatController::class, 'update'])->name('perangkat.update');
    Route::delete('/perangkat/{id}', [WebPerangkatController::class, 'destroy'])->name('perangkat.destroy');

    // PO - CRUD
    Route::get('/purchase-order/create', [WebPurchaseOrderController::class, 'create'])->name('purchase-order.create');
    Route::post('/purchase-order', [WebPurchaseOrderController::class, 'store'])->name('purchase-order.store');
    Route::get('/purchase-order/{id}/edit', [WebPurchaseOrderController::class, 'edit'])->name('purchase-order.edit');
    Route::put('/purchase-order/{id}', [WebPurchaseOrderController::class, 'update'])->name('purchase-order.update');
    Route::delete('/purchase-order/{id}', [WebPurchaseOrderController::class, 'destroy'])->name('purchase-order.destroy');
});

// ========== MANAJER, ADMIN & NOC - Lihat Inventory ==========
Route::middleware(['auth', 'role:manajer,admin,noc'])->group(function () {
    Route::get('/inventory', [WebInventoryController::class, 'index'])->name('inventory.index');
    
    Route::get('/inventory/available-serials', [WebInventoryController::class, 'getAvailableSerials'])->name('inventory.available-serials');
    Route::get('/inventory/returnable-serials', [WebInventoryController::class, 'getReturnableSerials'])->name('inventory.returnable-serials');
});

// ========== NOC ONLY - Inventory Input/Update ==========
Route::middleware(['auth', 'role:noc'])->group(function () {
    Route::get('/inventory/create', [WebInventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [WebInventoryController::class, 'store'])->name('inventory.store');    
    Route::get('/inventory/{id}/edit/{type}', [WebInventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}/{type}', [WebInventoryController::class, 'update'])->name('inventory.update');
});

// ========== MANAJER, ADMIN, NOC - Lihat PO ==========
Route::middleware(['auth', 'role:manajer,admin,noc'])->group(function () {
    Route::get('/purchase-order', [WebPurchaseOrderController::class, 'index'])->name('purchase-order.index');
    Route::get('/purchase-order/{id}', [WebPurchaseOrderController::class, 'show'])->name('purchase-order.show');
});