<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // 1. Ambil data user DENGAN PAGINATION
        $users = \App\Models\User::latest()->paginate(10);

        // 2. Ambil data booking (PAID prioritas paling atas, lalu urutkan yang terbaru)
        $bookings = \App\Models\Booking::with(['user', 'product', 'participants'])
                        ->orderByRaw("CASE WHEN status = 'paid' THEN 1 ELSE 2 END")
                        ->latest()
                        ->get();

        // 3. Kirim keduanya ke view
        return view('admin.users.index', compact('users', 'bookings'));
    }
}