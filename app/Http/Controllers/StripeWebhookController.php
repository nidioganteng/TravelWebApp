<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function __construct(private readonly BookingPaymentService $paymentService) {}

    public function handle(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Exception $e) {
            Log::error('Stripe Webhook signature invalid: '.$e->getMessage());

            return response()->json(['error' => 'Invalid signature'], 400);
        }

        match ($event->type) {
            'checkout.session.completed' => $this->handleSessionCompleted($event->data->object),
            'checkout.session.async_payment_succeeded' => $this->handleAsyncPaymentSucceeded($event->data->object),
            'checkout.session.async_payment_failed' => $this->handleAsyncPaymentFailed($event->data->object),
            default => null,
        };

        return response()->json(['status' => 'ok']);
    }

    private function handleSessionCompleted(object $session): void
    {
        if ($session->payment_status !== 'paid') {
            return;
        }

        $this->processPayment($session->id);
    }

    private function handleAsyncPaymentSucceeded(object $session): void
    {
        $this->processPayment($session->id);
    }

    private function handleAsyncPaymentFailed(object $session): void
    {
        Log::warning("Stripe async payment failed for session {$session->id}. Tindak lanjut manual mungkin diperlukan.");
    }

    private function processPayment(string $sessionId): void
    {
        $booking = Booking::where('stripe_session_id', $sessionId)->first();

        if (! $booking) {
            Log::warning("Stripe webhook: no booking found for session {$sessionId}.");

            return;
        }

        $this->paymentService->markAsPaid($booking);
    }
}
