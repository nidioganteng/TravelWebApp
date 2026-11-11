<?php

use App\Models\Booking;
use App\Models\Product;
use App\Models\User;
use App\Services\BookingPaymentService;
use Mockery\MockInterface;

it('redirects with error when session_id is missing', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('checkout.success'))
        ->assertRedirect(route('profile.booking'))
        ->assertSessionHasErrors('error');
});

it('returns 404 when session_id does not match any booking', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('checkout.success', ['session_id' => 'cs_nonexistent']))
        ->assertNotFound();
});

it('returns 403 when booking belongs to another user', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $product = Product::factory()->create(['ticket_quota' => 10]);
    $booking = Booking::factory()->create([
        'user_id' => $owner->id,
        'product_id' => $product->id,
    ]);

    $this->actingAs($other)
        ->get(route('checkout.success', ['session_id' => $booking->stripe_session_id]))
        ->assertForbidden();
});

it('redirects with error when stripe session retrieve fails', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['ticket_quota' => 10]);
    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'product_id' => $product->id,
    ]);

    $this->mock(BookingPaymentService::class, function (MockInterface $mock) {
        $mock->shouldReceive('retrieveCheckoutSession')->once()->andReturn(null);
        $mock->shouldNotReceive('markAsPaid');
    });

    $this->actingAs($user)
        ->get(route('checkout.success', ['session_id' => $booking->stripe_session_id]))
        ->assertRedirect(route('profile.booking'))
        ->assertSessionHasErrors('error');
});

it('redirects with error when stripe payment_status is not paid', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['ticket_quota' => 10]);
    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'product_id' => $product->id,
    ]);

    $fakeSession = new stdClass;
    $fakeSession->payment_status = 'unpaid';

    $this->mock(BookingPaymentService::class, function (MockInterface $mock) use ($fakeSession) {
        $mock->shouldReceive('retrieveCheckoutSession')->once()->andReturn($fakeSession);
        $mock->shouldNotReceive('markAsPaid');
    });

    $this->actingAs($user)
        ->get(route('checkout.success', ['session_id' => $booking->stripe_session_id]))
        ->assertRedirect(route('profile.booking'))
        ->assertSessionHasErrors('error');
});

it('marks booking paid and redirects on successful stripe session', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['ticket_quota' => 10]);
    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'product_id' => $product->id,
    ]);

    $fakeSession = new stdClass;
    $fakeSession->payment_status = 'paid';

    $this->mock(BookingPaymentService::class, function (MockInterface $mock) use ($fakeSession) {
        $mock->shouldReceive('retrieveCheckoutSession')->once()->andReturn($fakeSession);
        $mock->shouldReceive('markAsPaid')->once();
    });

    $this->actingAs($user)
        ->get(route('checkout.success', ['session_id' => $booking->stripe_session_id]))
        ->assertRedirect(route('profile.booking'))
        ->assertSessionHas('success');
});
