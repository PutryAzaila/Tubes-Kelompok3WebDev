<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KategoriVendorController;
use App\Http\Controllers\Api\DataVendorController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Kategori Vendor Routes
Route::prefix('kategori-vendor')->group(function () {
    Route::get('/', [KategoriVendorController::class, 'index']);
    Route::post('/', [KategoriVendorController::class, 'store']);
    Route::get('/{id}', [KategoriVendorController::class, 'show']);
    Route::put('/{id}', [KategoriVendorController::class, 'update']);
    Route::delete('/{id}', [KategoriVendorController::class, 'destroy']);
});

// Data Vendor Routes
Route::prefix('vendor')->group(function () {
    Route::get('/', [DataVendorController::class, 'index']);
    Route::post('/', [DataVendorController::class, 'store']);
    Route::get('/{id}', [DataVendorController::class, 'show']);
    Route::put('/{id}', [DataVendorController::class, 'update']);
    Route::delete('/{id}', [DataVendorController::class, 'destroy']);
    Route::get('/kategori/{kategoriId}', [DataVendorController::class, 'getByCategory']);
});