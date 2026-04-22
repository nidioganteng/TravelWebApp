<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Message;
use App\Models\Product;
use App\Models\TrackRecord;

class DashboardController extends Controller
{
    public function index()
    {
        $total_visited_places = TrackRecord::count();
        $recent_messages      = Message::latest()->take(3)->get();
        $recent_products      = Product::latest()->take(2)->get();

        $total_bookings       = Booking::count();
        $total_paid           = Booking::where('status', 'paid')->count();
        $total_unpaid         = Booking::where('status', 'unpaid')->count();
        $total_revenue        = Booking::where('status', 'paid')->sum('total_price');
        $recent_bookings      = Booking::with(['user', 'product'])
                                    ->where('status', 'paid')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return view('admin.dashboard', compact(
            'total_visited_places',
            'recent_messages',
            'recent_products',
            'total_bookings',
            'total_paid',
            'total_unpaid',
            'total_revenue',
            'recent_bookings',
        ));
    }
}