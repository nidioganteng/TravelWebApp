<?php

use App\Models\Message;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

beforeEach(function () {
    Cache::flush();
});

function validContactPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'message' => 'This is a test message that is long enough to pass validation.',
        'form_token' => Crypt::encryptString((string) (time() - 10)),
        'website_url' => '',
    ], $overrides);
}

it('stores a valid contact message', function () {
    $this->withoutMiddleware(ThrottleRequests::class);

    $this->post(route('contact.store'), validContactPayload())
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(Message::count())->toBe(1);
});

it('silently accepts honeypot submissions without storing message', function () {
    $this->withoutMiddleware(ThrottleRequests::class);

    $this->post(route('contact.store'), validContactPayload([
        'website_url' => 'http://spam.com',
    ]))->assertRedirect()->assertSessionHas('success');

    expect(Message::count())->toBe(0);
});

it('silently accepts submissions that arrive too fast (time trap)', function () {
    $this->withoutMiddleware(ThrottleRequests::class);

    $this->post(route('contact.store'), validContactPayload([
        'form_token' => Crypt::encryptString((string) time()),
    ]))->assertRedirect()->assertSessionHas('success');

    expect(Message::count())->toBe(0);
});

it('silently accepts submissions with expired token (over 2 hours)', function () {
    $this->withoutMiddleware(ThrottleRequests::class);

    $this->post(route('contact.store'), validContactPayload([
        'form_token' => Crypt::encryptString((string) (time() - 7300)),
    ]))->assertRedirect()->assertSessionHas('success');

    expect(Message::count())->toBe(0);
});

it('silently accepts submissions with missing or invalid token', function () {
    $this->withoutMiddleware(ThrottleRequests::class);

    $this->post(route('contact.store'), validContactPayload([
        'form_token' => 'totally-invalid-token',
    ]))->assertRedirect()->assertSessionHas('success');

    expect(Message::count())->toBe(0);
});

it('rejects message containing a URL', function () {
    $this->withoutMiddleware(ThrottleRequests::class);

    $this->post(route('contact.store'), validContactPayload([
        'message' => 'Visit my site: https://spam.com for great deals!',
    ]))->assertSessionHasErrors('message');

    expect(Message::count())->toBe(0);
});

it('rejects message containing www. link', function () {
    $this->withoutMiddleware(ThrottleRequests::class);

    $this->post(route('contact.store'), validContactPayload([
        'message' => 'Go to www.spam.com for details.',
    ]))->assertSessionHasErrors('message');

    expect(Message::count())->toBe(0);
});

it('rejects name containing HTML angle brackets', function () {
    $this->withoutMiddleware(ThrottleRequests::class);

    $this->post(route('contact.store'), validContactPayload([
        'name' => 'John <Doe>',
    ]))->assertSessionHasErrors('name');

    expect(Message::count())->toBe(0);
});

it('rejects name containing http', function () {
    $this->withoutMiddleware(ThrottleRequests::class);

    $this->post(route('contact.store'), validContactPayload([
        'name' => 'John http Doe',
    ]))->assertSessionHasErrors('name');

    expect(Message::count())->toBe(0);
});

it('throttles contact form after 3 per-ip submissions per 10 minutes', function () {
    for ($i = 0; $i < 3; $i++) {
        $this->post(route('contact.store'), validContactPayload());
    }

    $this->post(route('contact.store'), validContactPayload())
        ->assertRedirect()
        ->assertSessionHasErrors('error');

    expect(Message::count())->toBe(3);
});

it('silently rejects same email after 3 messages per hour', function () {
    $this->withoutMiddleware(ThrottleRequests::class);

    $email = 'spammer@example.com';

    for ($i = 0; $i < 3; $i++) {
        $this->post(route('contact.store'), validContactPayload(['email' => $email]));
    }

    expect(Message::count())->toBe(3);

    $this->post(route('contact.store'), validContactPayload(['email' => $email]))
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(Message::count())->toBe(3);
});
