<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // KONDISI 1: User belum login sama sekali
        if (!Auth::check()) {
            // Arahkan ke Login Khusus Admin
            return redirect()->route('admin.login');
        }

        // KONDISI 2: Sudah login, tapi Role-nya bukan Admin
        if (Auth::user()->role !== 'admin') {
            // Tendang balik ke halaman depan (atau halaman error 403)
            return redirect('/')->with('error', 'Anda bukan Admin!');
        }

        // KONDISI 3: Sudah login & Role admin (Lolos)
        return $next($request);
    }
}
