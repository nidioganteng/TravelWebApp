<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $tripsData = Product::where('is_published', true)->latest()->get();

        return view('front.products', compact('tripsData'));
    }
}
