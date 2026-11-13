<?php

use App\Models\Product;
use App\Models\TrackRecord;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;

// ─── Item 7: Mass-assignment protection ──────────────────────────────────────

it('profile update cannot change user role', function () {
    $user = User::factory()->create(['role' => 'user']);
    $this->actingAs($user);

    $this->patch(route('profile.update'), [
        'name' => 'Hacked Name',
        'email' => $user->email,
        'role' => 'admin',
    ]);

    expect($user->fresh()->role)->toBe('user');
});

it('profile update cannot change user status', function () {
    $user = User::factory()->create(['status' => 'verify']);
    $this->actingAs($user);

    $this->patch(route('profile.update'), [
        'name' => 'Hacked Name',
        'email' => $user->email,
        'status' => 'active',
    ]);

    expect($user->fresh()->status)->toBe('verify');
});

it('registration cannot set role to admin via mass assignment', function () {
    $this->post('/register', [
        'name' => 'Evil User',
        'email' => 'evil@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'admin',
    ]);

    $user = User::where('email', 'evil@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->role)->not->toBe('admin');
});

it('new registered user gets status verify', function () {
    $this->post('/register', [
        'name' => 'New User',
        'email' => 'newuser@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $user = User::where('email', 'newuser@example.com')->first();
    expect($user->status)->toBe('verify');
});

// ─── Item 8: SecurityHeaders middleware ──────────────────────────────────────

it('web responses include X-Frame-Options SAMEORIGIN', function () {
    $response = $this->get('/');

    $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
});

it('web responses include X-Content-Type-Options nosniff', function () {
    $response = $this->get('/');

    $response->assertHeader('X-Content-Type-Options', 'nosniff');
});

it('web responses include Referrer-Policy', function () {
    $response = $this->get('/');

    $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
});

it('web responses include CSP report-only header', function () {
    $response = $this->get('/');

    expect($response->headers->has('Content-Security-Policy-Report-Only'))->toBeTrue();
});

// ─── Item 10: delete_images validation ───────────────────────────────────────

it('admin product update rejects delete_images path not belonging to product', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $this->actingAs($admin);

    $product = Product::factory()->create([
        'product_image' => ['products/real-image.jpg'],
    ]);

    $this->patch(route('admin.products.update', $product), [
        'product_name' => $product->product_name,
        'product_price' => $product->product_price,
        'ticket_quota' => $product->ticket_quota,
        'departure_date' => now()->addDays(30)->format('Y-m-d'),
        'delete_images' => ['products/../../../etc/passwd'],
    ])->assertSessionHasErrors('delete_images.0');
});

// ─── Item 11: CheckoutController validation ───────────────────────────────────

it('checkout process rejects quantity above 20', function () {
    $user = User::factory()->create(['status' => 'active']);
    $this->actingAs($user);

    $product = Product::factory()->create(['ticket_quota' => 100]);

    $this->post(route('checkout.process', $product), [
        'quantity' => 21,
        'contact_email' => 'test@example.com',
        'contact_phone' => '0612345678',
        'participants' => array_fill(0, 21, ['name' => 'Peserta', 'category' => 'Adult']),
    ])->assertSessionHasErrors('quantity');
});

it('checkout process rejects when participant count differs from quantity', function () {
    $user = User::factory()->create(['status' => 'active']);
    $this->actingAs($user);

    $product = Product::factory()->create(['ticket_quota' => 10]);

    $this->post(route('checkout.process', $product), [
        'quantity' => 3,
        'contact_email' => 'test@example.com',
        'contact_phone' => '0612345678',
        'participants' => [
            ['name' => 'Peserta 1', 'category' => 'Adult'],
            ['name' => 'Peserta 2', 'category' => 'Adult'],
        ],
    ])->assertSessionHasErrors('participants');
});

// ─── Item 12: TrackUserActivity throttle ─────────────────────────────────────

it('TrackUserActivity only updates DB once per 5 minutes', function () {
    $user = User::factory()->create(['status' => 'active']);
    $this->actingAs($user);

    Cache::flush();

    $this->get('/');
    $firstSeenAt = $user->fresh()->last_seen_at;
    $firstPage = $user->fresh()->last_page;

    // Second request within 5 minutes should NOT update DB
    $this->get('/contact');

    expect($user->fresh()->last_seen_at->toDateTimeString())
        ->toBe($firstSeenAt->toDateTimeString());
    expect($user->fresh()->last_page)->toBe($firstPage);
});

// ─── Item 15: Route admin toggle URL fixed ───────────────────────────────────

it('admin products toggle route has correct URL without double admin prefix', function () {
    $url = route('admin.products.toggle', 1);

    expect($url)->not->toContain('/admin/admin/');
    expect($url)->toContain('/admin/products/1/toggle');
});

// ─── Item 10 (TravelRecordController): svg rejected in update ─────────────────

it('admin travel record update rejects svg banner_image', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $this->actingAs($admin);

    $record = TrackRecord::factory()->create();

    $svgFile = UploadedFile::fake()->create('malicious.svg', 10, 'image/svg+xml');

    $this->patch(route('admin.travel-records.update', $record), [
        'city_name' => $record->city_name,
        'description' => $record->description,
        'year' => $record->year,
        'banner_image' => $svgFile,
        'items' => [['title' => 'T', 'description' => 'D', 'old_image' => 'x.jpg']],
    ])->assertSessionHasErrors('banner_image');
});
