<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret    = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Exception $e) {
            Log::error('Stripe Webhook signature invalid: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $this->handlePaymentSuccess($session->id);
        }

        return response()->json(['status' => 'ok']);
    }

    private function handlePaymentSuccess(string $sessionId): void
    {
        $booking = Booking::with(['product', 'participants'])->where('stripe_session_id', $sessionId)->first();

        if (!$booking || $booking->status === 'paid') {
            return;
        }

        $booking->update(['status' => 'paid']);
        $booking->product->decrement('ticket_quota', $booking->quantity);

        try {
            Mail::to($booking->contact_email)->send(new BookingConfirmationMail($booking));
        } catch (\Exception $e) {
            Log::error('Failed to send booking confirmation email via webhook: ' . $e->getMessage());
        }

        Log::info("Booking {$booking->booking_reference} marked as paid via webhook.");
    }
}
