<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route; // <-- Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Blade directive untuk cek role
        Blade::if('role', function (...$roles) {
            if (!auth()->check()) {
                return false;
            }
            
            $userJabatan = strtolower(auth()->user()->jabatan ?? '');
            $allowedRoles = array_map('strtolower', $roles);
            
            return in_array($userJabatan, $allowedRoles);
        });

        // TAMBAHKAN KODE INI untuk memuat API routes
        Route::prefix('api')
             ->middleware('api')
             ->namespace('App\Http\Controllers\Api') // Penting: namespace untuk controllers
             ->group(base_path('routes/api.php'));
    }
}