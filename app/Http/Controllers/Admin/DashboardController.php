<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
// use App\Models\Product; (Nanti dibuka kalau modelnya sudah ada)
// use App\Models\Booking; (Nanti dibuka kalau modelnya sudah ada)

class DashboardController extends Controller
{
    public function index()
    {
        // Contoh mengambil data untuk statistik
        // Kalau Model Booking/Product belum ada, kita kasih angka 0 dulu biar gak error
        $total_users = User::where('role', 'user')->count();
        $total_bookings = 0; // Nanti ganti jadi: Booking::count();
        $total_products = 0; // Nanti ganti jadi: Product::count();

        return view('admin.dashboard', compact('total_users', 'total_bookings', 'total_products'));
    }
}
