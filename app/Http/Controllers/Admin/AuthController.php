<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login admin
     */
    public function showLogin()
    {
        // Jika admin sudah login, langsung ke dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Key untuk rate limit (berdasarkan username + IP)
        $throttleKey = Str::lower($request->username).'|'.$request->ip();

        // Maksimal 3 percobaan
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'username' => "Terlalu banyak percobaan login. Silakan tunggu {$seconds} detik sebelum mencoba kembali.",
            ]);
        }

        // Coba login
        if (!Auth::guard('admin')->attempt(
            $request->only('username', 'password'),
            $request->boolean('remember')
        )) {
            // Tambah hit rate limit
            RateLimiter::hit($throttleKey, 60); // 1 menit (bisa 60–180 detik)

            throw ValidationException::withMessages([
                'username' => 'Username atau password salah.',
            ]);
        }

        // Login berhasil → hapus rate limit
        RateLimiter::clear($throttleKey);

        // Regenerate session (anti session fixation)
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
