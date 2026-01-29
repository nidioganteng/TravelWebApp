<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message; // Import Model

class MessageController extends Controller
{
    // MENAMPILKAN DAFTAR PESAN
    public function index()
    {
        // Ambil semua pesan, urutkan dari yang terbaru (latest)
        $messages = Message::latest()->get();
        
        // Kirim ke view admin
        return view('admin.message', compact('messages'));
    }

    // MENGHAPUS PESAN
    public function destroy($id)
    {
        $message = Message::findOrFail($id); // Cari pesan
        $message->delete(); // Hapus

        return redirect()->back()->with('success', 'Pesan berhasil dihapus.');
    }
}