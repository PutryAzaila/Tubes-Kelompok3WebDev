<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class WebAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/dashboard')->with('info', 'Anda sudah login!');
        }
        
        return view('login');
    }

    // login request
    public function login(Request $request)
    {
        try {
            // Validasi input
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ], [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 6 karakter.',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()
                    ->withErrors(['email' => 'Email tidak terdaftar dalam sistem.'])
                    ->withInput($request->only('email'));
            }

            if (!Hash::check($request->password, $user->password)) {
                return back()
                    ->withErrors(['password' => 'Password yang Anda masukkan salah.'])
                    ->withInput($request->only('email'));
            }

            // Login user
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();
            
            // FIXED: Redirect ke dashboard, bukan inventory
            return redirect()
                ->route('dashboard')
                ->with('success', 'Selamat datang, ' . $user->nama_lengkap . '!');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput($request->only('email'));
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.')
                ->withInput($request->only('email'));
        }
    }

    // Handle logout request
    public function logout(Request $request)
    {
        $userName = Auth::user()->nama_lengkap ?? 'User';
        
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Sampai jumpa, ' . $userName . '! Logout berhasil.');
    }
}