<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Product;
use App\Models\TrackRecord;

class DashboardController extends Controller
{
    public function index()
    {
        $total_visited_places = TrackRecord::count();
        $recent_messages = Message::latest()->take(3)->get();
        $recent_products = Product::latest()->take(2)->get();

        return view('admin.dashboard', compact(
            'total_visited_places',
            'recent_messages',
            'recent_products'
        ));
    }
}