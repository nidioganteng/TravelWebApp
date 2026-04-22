<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'product', 'participants'])
            ->orderByRaw("CASE WHEN status = 'paid' THEN 1 ELSE 2 END")
            ->latest()
            ->get();

        $totalRevenue = Booking::where('status', 'paid')->sum('total_price');
        $totalPaid    = Booking::where('status', 'paid')->count();
        $totalUnpaid  = Booking::where('status', 'unpaid')->count();

        return view('admin.bookings.index', compact('bookings', 'totalRevenue', 'totalPaid', 'totalUnpaid'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:paid,unpaid',
        ]);

        DB::transaction(function () use ($request, $booking) {
            $oldStatus = $booking->status;
            $newStatus = $request->status;

            // Kalau dari unpaid → paid: kurangi quota tiket
            if ($oldStatus === 'unpaid' && $newStatus === 'paid') {
                $booking->product->decrement('ticket_quota', $booking->quantity);
            }

            // Kalau dari paid → unpaid: kembalikan quota tiket
            if ($oldStatus === 'paid' && $newStatus === 'unpaid') {
                $booking->product->increment('ticket_quota', $booking->quantity);
            }

            $booking->update(['status' => $newStatus]);
        });

        return back()->with('success', "Booking {$booking->booking_reference} status updated to {$request->status}.");
    }

    public function destroy(Booking $booking)
    {
        DB::transaction(function () use ($booking) {
            // Kalau booking sudah paid, kembalikan quota tiket sebelum dihapus
            if ($booking->status === 'paid') {
                $booking->product->increment('ticket_quota', $booking->quantity);
            }

            // Participants terhapus otomatis karena cascade delete di migration
            $booking->delete();
        });

        return back()->with('success', "Booking {$booking->booking_reference} has been deleted.");
    }
}
