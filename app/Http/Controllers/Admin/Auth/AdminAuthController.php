<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // 1. Tampilkan Halaman Login Admin
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // 2. Proses Login Admin
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // CEK ROLE: Apakah dia benar-benar Admin?
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            // Kalau ternyata dia User biasa yang coba login di form admin:
            Auth::logout();
            return back()->withErrors([
                'email' => 'Anda bukan Admin. Silakan login di halaman User.',
            ]);
        }

        // Kalau password salah
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // 3. Logout Admin
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
