<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!$request->user()) {
            return redirect('/login');
        }

        // Ambil jabatan user dan convert ke lowercase
        $userJabatan = strtolower($request->user()->jabatan);
        
        // Convert semua allowed roles ke lowercase juga
        $allowedRoles = array_map('strtolower', $roles);

        // Cek apakah jabatan user ada di list allowed roles
        if (!in_array($userJabatan, $allowedRoles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki permission untuk halaman ini.');
        }

        return $next($request);
    }
}