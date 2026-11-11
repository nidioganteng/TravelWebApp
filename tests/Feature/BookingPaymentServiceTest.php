<?php

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\Product;
use App\Services\BookingPaymentService;
use Illuminate\Support\Facades\Mail;

it('marks unpaid booking as paid and decrements quota', function () {
    Mail::fake();

    $product = Product::factory()->create(['ticket_quota' => 10]);
    $booking = Booking::factory()->create([
        'product_id' => $product->id,
        'quantity' => 2,
        'status' => 'unpaid',
    ]);

    $result = app(BookingPaymentService::class)->markAsPaid($booking);

    expect($result)->toBeTrue();
    expect($booking->fresh()->status)->toBe('paid');
    expect($product->fresh()->ticket_quota)->toBe(8);

    Mail::assertSent(BookingConfirmationMail::class);
});

it('is idempotent: calling markAsPaid twice only decrements quota once', function () {
    Mail::fake();

    $product = Product::factory()->create(['ticket_quota' => 10]);
    $booking = Booking::factory()->create([
        'product_id' => $product->id,
        'quantity' => 2,
        'status' => 'unpaid',
    ]);

    $service = app(BookingPaymentService::class);

    expect($service->markAsPaid($booking))->toBeTrue();
    expect($service->markAsPaid($booking))->toBeFalse();

    expect($product->fresh()->ticket_quota)->toBe(8);
    Mail::assertSent(BookingConfirmationMail::class, 1);
});

it('clamps quota to zero when quantity exceeds quota but still marks booking paid', function () {
    Mail::fake();

    $product = Product::factory()->create(['ticket_quota' => 1]);
    $booking = Booking::factory()->create([
        'product_id' => $product->id,
        'quantity' => 5,
        'status' => 'unpaid',
    ]);

    $result = app(BookingPaymentService::class)->markAsPaid($booking);

    expect($result)->toBeTrue();
    expect($booking->fresh()->status)->toBe('paid');
    expect($product->fresh()->ticket_quota)->toBe(0);

    Mail::assertSent(BookingConfirmationMail::class);
});

it('returns false for already paid booking without sending email', function () {
    Mail::fake();

    $product = Product::factory()->create(['ticket_quota' => 10]);
    $booking = Booking::factory()->paid()->create([
        'product_id' => $product->id,
        'quantity' => 2,
    ]);

    $result = app(BookingPaymentService::class)->markAsPaid($booking);

    expect($result)->toBeFalse();
    expect($product->fresh()->ticket_quota)->toBe(10);

    Mail::assertNotSent(BookingConfirmationMail::class);
});

it('simulates webhook and success both calling markAsPaid: quota only decremented once', function () {
    Mail::fake();

    $product = Product::factory()->create(['ticket_quota' => 10]);
    $booking = Booking::factory()->create([
        'product_id' => $product->id,
        'quantity' => 2,
        'status' => 'unpaid',
    ]);

    $service = app(BookingPaymentService::class);

    // Webhook dan success masing-masing memanggil markAsPaid
    $webhookResult = $service->markAsPaid($booking);
    $successResult = $service->markAsPaid($booking->fresh());

    expect($webhookResult)->toBeTrue();
    expect($successResult)->toBeFalse();
    expect($product->fresh()->ticket_quota)->toBe(8);

    Mail::assertSent(BookingConfirmationMail::class, 1);
});

it('email failure does not affect paid status', function () {
    Mail::shouldReceive('to')->andThrow(new \Exception('SMTP error'));

    $product = Product::factory()->create(['ticket_quota' => 10]);
    $booking = Booking::factory()->create([
        'product_id' => $product->id,
        'quantity' => 1,
        'status' => 'unpaid',
    ]);

    $result = app(BookingPaymentService::class)->markAsPaid($booking);

    expect($result)->toBeTrue();
    expect($booking->fresh()->status)->toBe('paid');
    expect($product->fresh()->ticket_quota)->toBe(9);
});
