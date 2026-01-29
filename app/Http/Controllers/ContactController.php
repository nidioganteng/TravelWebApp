<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message; 

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input (Wajib diisi)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // 2. Simpan ke Database
        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        // 3. Balik ke halaman contact dengan pesan sukses
        return redirect()->back()->with('success', 'Pesan berhasil dikirim! Terima kasih.');
    }
}