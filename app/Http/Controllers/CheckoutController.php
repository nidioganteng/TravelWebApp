<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientQuotaException;
use App\Models\Booking;
use App\Models\Product;
use App\Services\BookingPaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function __construct(private readonly BookingPaymentService $paymentService) {}

    public function process(Request $request, Product $product)
    {
        if ($product->isExpired()) {
            return back()->withErrors(['error' => 'Produk ini sudah expired dan tidak bisa dipesan.']);
        }

        // 1. Validasi Data
        $request->validate([
            'quantity' => 'required|integer|min:1|max:20',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'participants' => 'required|array',
            'participants.*.name' => 'required|string|max:100',
            'participants.*.category' => 'required|in:Adult,Child',
        ]);

        if (count($request->participants) !== (int) $request->quantity) {
            return back()
                ->withErrors(['participants' => 'Jumlah peserta harus sama dengan jumlah tiket yang dipesan.'])
                ->withInput();
        }

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
                    throw new InsufficientQuotaException($available);
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
                            'description' => 'Tanggal Keberangkatan: '.Carbon::parse($product->departure_date)->format('d M Y, H:i'),
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

        } catch (InsufficientQuotaException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        } catch (\Exception $e) {
            Log::error('Checkout Error: '.$e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.'])->withInput();
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

        if (! $sessionId) {
            return redirect()->route('profile.booking')
                ->withErrors(['error' => 'Link pembayaran tidak valid.']);
        }

        $booking = Booking::where('stripe_session_id', $sessionId)->firstOrFail();

        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $stripeSession = $this->paymentService->retrieveCheckoutSession($sessionId);

        if (! $stripeSession || $stripeSession->payment_status !== 'paid') {
            return redirect()->route('profile.booking')
                ->withErrors(['error' => 'Pembayaran belum selesai atau terjadi kesalahan. Silakan cek status booking Anda.']);
        }

        $this->paymentService->markAsPaid($booking);

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
                            'description' => 'Tanggal Keberangkatan: '.Carbon::parse($booking->product->departure_date)->format('d M Y, H:i'),
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

            return back()->withErrors(['error' => 'Terjadi kesalahan saat memproses pembayaran ulang. Silakan coba lagi.']);
        }
    }

    public function cancel()
    {
        return redirect('/products')->with('error', 'Payment Cancelled');
    }
}
