<?php

use App\Http\Controllers\Api\InventoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KategoriVendorController;
use App\Http\Controllers\Api\DataVendorController;
use App\Http\Controllers\Api\PerangkatController;
use App\Http\Controllers\Api\KategoriPerangkatController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\DetailPurchaseOrderController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (JWT authentication)
Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    Route::apiResource('inventory', InventoryController::class);
    
    // Kategori Perangkat Routes (Protected)
    Route::prefix('kategori-perangkat')->group(function () {
        Route::get('/', [KategoriPerangkatController::class, 'index']);
        Route::post('/', [KategoriPerangkatController::class, 'store']);
        Route::get('/{id}', [KategoriPerangkatController::class, 'show']);
        Route::put('/{id}', [KategoriPerangkatController::class, 'update']);
        Route::delete('/{id}', [KategoriPerangkatController::class, 'destroy']);
    });

    // Perangkat Routes (Protected)
    Route::prefix('perangkat')->group(function () {
        Route::get('/', [PerangkatController::class, 'index']);
        Route::get('/statistics', [PerangkatController::class, 'statistics']);
        Route::get('/export', [PerangkatController::class, 'export']);
        Route::get('/{id}', [PerangkatController::class, 'show']);
        Route::post('/', [PerangkatController::class, 'store']);
        Route::put('/{id}', [PerangkatController::class, 'update']);
        Route::delete('/{id}', [PerangkatController::class, 'destroy']);
    });

    // Kategori Vendor Routes (Protected)
    Route::prefix('kategori-vendor')->group(function () {
        Route::get('/', [KategoriVendorController::class, 'index']);
        Route::post('/', [KategoriVendorController::class, 'store']);
        Route::get('/{id}', [KategoriVendorController::class, 'show']);
        Route::put('/{id}', [KategoriVendorController::class, 'update']);
        Route::delete('/{id}', [KategoriVendorController::class, 'destroy']);
    });

    // Data Vendor Routes (Protected)
    Route::prefix('vendor')->group(function () {
        Route::get('/', [DataVendorController::class, 'index']);
        Route::post('/', [DataVendorController::class, 'store']);
        Route::get('/{id}', [DataVendorController::class, 'show']);
        Route::put('/{id}', [DataVendorController::class, 'update']);
        Route::delete('/{id}', [DataVendorController::class, 'destroy']);
        Route::get('/kategori/{kategoriId}', [DataVendorController::class, 'getByCategory']);
    });

    // Purchase Order Routes (Protected) - CRUD dan manajemen status
    Route::prefix('purchase-orders')->group(function () {
        // CRUD Routes
        Route::get('/', [PurchaseOrderController::class, 'index']);
        Route::post('/', [PurchaseOrderController::class, 'store']);
        Route::get('/{id}', [PurchaseOrderController::class, 'show']);
        Route::get('/{id}/edit', [PurchaseOrderController::class, 'edit']);
        Route::put('/{id}', [PurchaseOrderController::class, 'update']);
        Route::delete('/{id}', [PurchaseOrderController::class, 'destroy']);
        
        // Dashboard Stats
        Route::get('/stats/dashboard', [PurchaseOrderController::class, 'getDashboardStats']);
        
        // Check stock
        Route::get('/check-stock/{id_perangkat}', [PurchaseOrderController::class, 'checkStock']);
    });

    // Detail Purchase Order Routes (Protected) - View detail dan update status
    Route::prefix('detail-purchase-orders')->group(function () {
        // Get details by PO ID - Melihat detail PO
        Route::get('/by-po/{id_po}', [DetailPurchaseOrderController::class, 'getByPurchaseOrder']);
        
        // Update status persetujuan PO dari halaman detail
        Route::patch('/{id_po}/approve', [DetailPurchaseOrderController::class, 'approveStatus']);
        Route::patch('/{id_po}/reject', [DetailPurchaseOrderController::class, 'rejectStatus']);
    });
});