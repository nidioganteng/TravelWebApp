<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Booking;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function process(Request $request, Product $product)
    {
       // 1. Validasi Data
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->ticket_quota,
            'contact_email' => 'required|email', // <-- Validasi baru
            'contact_phone' => 'required|string|max:20', // <-- Validasi baru
            'participants' => 'required|array',
            'participants.*.name' => 'required|string|max:255',
            'participants.*.category' => 'required|in:Adult,Child',
        ]);

        try {
            // 2. Buat Data Booking Induk
            $booking = Booking::create([
                'booking_reference' => 'BKG-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'total_price' => $product->product_price * $request->quantity,
                'status' => 'unpaid',
                'contact_email' => $request->contact_email, 
                'contact_phone' => $request->contact_phone, 
            ]);

            // 3. SIMPAN DATA PENUMPANG (Ini yang baru!)
            foreach ($request->participants as $participant) {
                $booking->participants()->create([
                    'name' => $participant['name'],
                    'category' => $participant['category'],
                ]);
            }

            // 4. Konfigurasi Stripe
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // 5. Buat Sesi Pembayaran (Checkout Session) di Stripe
            $checkout_session = Session::create([
                'payment_method_types' => ['card', 'ideal'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product->product_name,
                            'description' => 'Tanggal Keberangkatan: ' . \Carbon\Carbon::parse($product->departure_date)->format('d M Y, H:i'),
                        ],
                        'unit_amount' => intval($product->product_price * 100),
                    ],
                    'quantity' => $request->quantity,
                ]],
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
            ]);

            // 6. Simpan ID Sesi Stripe ke Database
            $booking->update(['stripe_session_id' => $checkout_session->id]);

            // 7. Lempar User ke Halaman Stripe
            return redirect($checkout_session->url);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Stripe Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal memproses pesanan: ' . $e->getMessage()]);
        }
    }

    public function details(Request $request, Product $product)
    {
        // Ambil jumlah tiket yang dipilih user (default 1)
        $quantity = $request->query('quantity', 1);

        // Validasi: Cegah user iseng masukin angka 0 atau melebihi kuota
        if ($quantity < 1 || $quantity > $product->ticket_quota) {
            return redirect()->back()->withErrors(['error' => 'Jumlah tiket tidak valid.']);
        }

        // Buka halaman form data diri
        return view('profile.checkout-details', compact('product', 'quantity'));
    }

    public function success(Request $request)
    {
        // Halaman ini akan dipanggil otomatis oleh Stripe saat pembayaran SUKSES
        $sessionId = $request->get('session_id');
        
        $booking = Booking::where('stripe_session_id', $sessionId)->firstOrFail();
        
        // Ubah status jadi PAID
        $booking->update(['status' => 'paid']);

        // Kurangi Kuota Produk di database
        $product = $booking->product;
        $product->decrement('ticket_quota', $booking->quantity);

        // Arahkan user ke halaman E-Ticket dengan pesan sukses
        return redirect()->route('profile.booking')->with('success', 'Payment successful! Here is your E-Ticket.');
    }

    public function cancel()
    {
        return redirect('/products')->with('error', 'Payment Cancelled');
    }


}