<?php

namespace App\Services;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;

class BookingPaymentService
{
    /**
     * Marks a booking as paid atomically.
     *
     * Returns true if newly marked paid, false if already paid (idempotent).
     * If quota is insufficient when payment arrives, booking is still marked paid
     * and quota is clamped to 0. A warning is logged for manual follow-up.
     *
     * Lock order: booking first, then product — consistent with no other path that
     * locks both, preventing deadlock.
     */
    public function markAsPaid(Booking $booking): bool
    {
        $markedPaidId = DB::transaction(function () use ($booking) {
            $locked = Booking::lockForUpdate()->findOrFail($booking->id);

            if ($locked->status === 'paid') {
                return false;
            }

            $product = Product::lockForUpdate()->findOrFail($locked->product_id);

            $locked->update(['status' => 'paid']);

            $newQuota = max(0, $product->ticket_quota - $locked->quantity);

            if ($product->ticket_quota < $locked->quantity) {
                Log::warning(
                    "Booking {$locked->booking_reference}: kuota tidak cukup saat marking paid ".
                    "(kuota: {$product->ticket_quota}, quantity: {$locked->quantity}). ".
                    'Booking tetap paid, kuota di-clamp ke 0. Tindak lanjut manual diperlukan.'
                );
            }

            $product->update(['ticket_quota' => $newQuota]);

            return $locked->id;
        });

        if ($markedPaidId === false) {
            return false;
        }

        $freshBooking = Booking::with(['product', 'participants'])->find($markedPaidId);

        if ($freshBooking) {
            Log::info("Booking {$freshBooking->booking_reference} marked as paid.");

            try {
                Mail::to($freshBooking->contact_email)->send(new BookingConfirmationMail($freshBooking));
            } catch (\Exception $e) {
                Log::error("Failed to send booking confirmation email for {$freshBooking->booking_reference}: {$e->getMessage()}");
            }
        }

        return true;
    }

    /**
     * Retrieves a Stripe Checkout Session.
     * Returns null and logs on failure — caller decides how to respond.
     *
     * Return type is `object|null` (not `\Stripe\Checkout\Session|null`) intentionally
     * so this method can be mocked easily in tests without Stripe SDK constraints.
     *
     * @return \Stripe\Checkout\Session|null
     */
    public function retrieveCheckoutSession(string $sessionId): ?object
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            return Session::retrieve($sessionId);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve Stripe session {$sessionId}: {$e->getMessage()}");

            return null;
        }
    }
}
