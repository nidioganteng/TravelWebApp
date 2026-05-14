<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function process(Request $request, Product $product)
    {
        if ($product->isExpired()) {
            return back()->withErrors(['error' => 'Produk ini sudah expired dan tidak bisa dipesan.']);
        }

        // 1. Validasi Data
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'participants' => 'required|array',
            'participants.*.name' => 'required|string|max:255',
            'participants.*.category' => 'required|in:Adult,Child',
        ]);

        // 2. Cek ketersediaan quota secara real-time (pakai DB lock)
        try {
            $booking = DB::transaction(function () use ($request, $product) {

                // Kunci baris product agar tidak ada race condition
                $product = Product::lockForUpdate()->findOrFail($product->id);

                // Hitung tiket yang sudah direservasi oleh booking unpaid (dalam 2 jam terakhir)
                $reserved = Booking::where('product_id', $product->id)
                    ->where('status', 'unpaid')
                    ->where('created_at', '>=', now()->subHours(2))
                    ->sum('quantity');

                $available = $product->ticket_quota - $reserved;

                if ($request->quantity > $available) {
                    throw new \Exception("Maaf, sisa tiket tersedia hanya {$available}. Silakan kurangi jumlah tiket.");
                }

                // 3. Buat Booking
                $booking = Booking::create([
                    'booking_reference' => 'BKG-'.date('Ymd').'-'.strtoupper(uniqid()),
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'total_price' => $product->product_price * $request->quantity,
                    'status' => 'unpaid',
                    'contact_email' => $request->contact_email,
                    'contact_phone' => $request->contact_phone,
                ]);

                // 4. Simpan Data Penumpang
                foreach ($request->participants as $participant) {
                    $booking->participants()->create([
                        'name' => $participant['name'],
                        'category' => $participant['category'],
                    ]);
                }

                return $booking;
            });

            // 5. Buat Sesi Stripe (di luar transaksi DB)
            Stripe::setApiKey(config('services.stripe.secret'));

            $checkout_session = Session::create([
                'payment_method_types' => ['card', 'ideal'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product->product_name,
                            'description' => 'Tanggal Keberangkatan: '.\Carbon\Carbon::parse($product->departure_date)->format('d M Y, H:i'),
                        ],
                        'unit_amount' => intval($product->product_price * 100),
                    ],
                    'quantity' => $request->quantity,
                ]],
                'mode' => 'payment',
                'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
            ]);

            // 6. Simpan ID Sesi Stripe
            $booking->update(['stripe_session_id' => $checkout_session->id]);

            // 7. Redirect ke Stripe
            return redirect($checkout_session->url);

        } catch (\Exception $e) {
            Log::error('Checkout Error: '.$e->getMessage());

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function details(Request $request, Product $product)
    {
        if ($product->isExpired()) {
            return redirect()->back()->withErrors(['error' => 'Produk ini sudah expired dan tidak bisa dipesan.']);
        }

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
        $sessionId = $request->get('session_id');

        $booking = Booking::with(['product', 'participants'])->where('stripe_session_id', $sessionId)->firstOrFail();

        // Hanya proses jika belum paid (webhook mungkin sudah jalan duluan)
        if ($booking->status !== 'paid') {
            $booking->update(['status' => 'paid']);
            $booking->product->decrement('ticket_quota', $booking->quantity);

            // Kirim email konfirmasi
            try {
                Mail::to($booking->contact_email)->send(new BookingConfirmationMail($booking));
            } catch (\Exception $e) {
                Log::error('Failed to send booking confirmation email: '.$e->getMessage());
            }
        }

        return redirect()->route('profile.booking')->with('success', 'Payment successful! Here is your E-Ticket.');
    }

    public function repay(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'unpaid') {
            return back()->withErrors(['error' => 'Only unpaid bookings can be retried.']);
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $checkout_session = Session::create([
                'payment_method_types' => ['card', 'ideal'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $booking->product->product_name,
                            'description' => 'Tanggal Keberangkatan: '.\Carbon\Carbon::parse($booking->product->departure_date)->format('d M Y, H:i'),
                        ],
                        'unit_amount' => intval($booking->product->product_price * 100),
                    ],
                    'quantity' => $booking->quantity,
                ]],
                'mode' => 'payment',
                'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
            ]);

            $booking->update(['stripe_session_id' => $checkout_session->id]);

            return redirect($checkout_session->url);

        } catch (\Exception $e) {
            Log::error('Repay Error: '.$e->getMessage());

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function cancel()
    {
        return redirect('/products')->with('error', 'Payment Cancelled');
    }
}
