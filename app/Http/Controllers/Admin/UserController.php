<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil semua user, diurutkan dari yang terakhir aktif. Menggunakan pagination agar rapi.
        $users = User::orderBy('last_seen_at', 'desc')->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }
}