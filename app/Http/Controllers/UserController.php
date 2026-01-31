<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil produk yang 'is_published' bernilai true (1)
        // Kita gunakan latest() supaya produk terbaru muncul di atas
        $tripsData = Product::where('is_published', true)->latest()->get();

        // Ganti dari 'productrip' ke 'front.products'
        return view('front.products', compact('tripsData'));
    }
}
