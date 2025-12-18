<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KategoriVendorController;
use App\Http\Controllers\Api\DataVendorController;
use App\Http\Controllers\Api\AuthController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (JWT authentication)
Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
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