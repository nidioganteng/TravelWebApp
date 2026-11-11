<?php

use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    Cache::flush();
});

it('register POST is throttled after 5 attempts per minute', function () {
    for ($i = 0; $i < 5; $i++) {
        $this->post('/register', [
            'name' => "User $i",
            'email' => "test{$i}@example.com",
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    }

    $this->post('/register', [
        'name' => 'User 6',
        'email' => 'test6@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect()
        ->assertSessionHasErrors('error');
});

it('forgot-password POST is throttled after 3 attempts per minute', function () {
    for ($i = 0; $i < 3; $i++) {
        $this->post('/forgot-password', [
            'email' => "test{$i}@example.com",
        ]);
    }

    $this->post('/forgot-password', [
        'email' => 'test4@example.com',
    ])->assertRedirect()
        ->assertSessionHasErrors('error');
});

it('lang switch GET is throttled after 30 attempts per minute', function () {
    for ($i = 0; $i < 30; $i++) {
        $this->get(route('lang.switch', 'en'));
    }

    $this->get(route('lang.switch', 'en'))
        ->assertRedirect()
        ->assertSessionHasErrors('error');
});
