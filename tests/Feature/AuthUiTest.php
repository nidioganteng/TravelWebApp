<?php

use App\Models\User;

// ── /login renders with key elements ───────────────────────────────────────

it('renders /login with status 200', function () {
    $this->get('/login')->assertOk();
});

it('login page contains email field', function () {
    $this->get('/login')->assertSee('id="email"', false);
});

it('login page contains password field', function () {
    $this->get('/login')->assertSee('id="password"', false);
});

it('login page contains link to register', function () {
    $this->get('/login')->assertSee(route('register'));
});

// ── /register renders with key elements ────────────────────────────────────

it('renders /register with status 200', function () {
    $this->get('/register')->assertOk();
});

it('register page contains email field', function () {
    $this->get('/register')->assertSee('id="email"', false);
});

it('register page contains password field', function () {
    $this->get('/register')->assertSee('id="password"', false);
});

it('register page contains link back to login', function () {
    $this->get('/register')->assertSee(route('login'));
});

// ── /forgot-password renders ────────────────────────────────────────────────

it('renders /forgot-password with status 200', function () {
    $this->get('/forgot-password')->assertOk();
});

// ── Navbar guest icon links to login ───────────────────────────────────────

it('navbar user icon for guests links to login not register', function () {
    $html = $this->get('/')->getContent();

    expect($html)->toContain('href="' . route('login') . '"');
});

it('navbar profile icon for guests does not point to register', function () {
    $response = $this->get('/');
    $dom      = new DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML($response->getContent());
    libxml_clear_errors();

    $xpath   = new DOMXPath($dom);
    $anchors = $xpath->query('//a[contains(@href, "' . route('register') . '")][./img[contains(@src, "profile.svg")]]');

    expect($anchors->length)->toBe(0);
});

// ── Failed login shows validation error ────────────────────────────────────

it('failed login with wrong password shows validation error', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email'    => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

it('failed login with unknown email shows validation error', function () {
    $response = $this->post('/login', [
        'email'    => 'nobody@example.com',
        'password' => 'password',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

// ── Guest accessing protected route is redirected to /login ────────────────

it('guest visiting /profile is redirected to /login', function () {
    $this->get('/profile')->assertRedirect('/login');
});
