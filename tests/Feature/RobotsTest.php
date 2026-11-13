<?php

it('robots.txt returns 200 with text/plain content type', function () {
    $this->get('/robots.txt')
        ->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
});

it('robots.txt allows all user agents', function () {
    $response = $this->get('/robots.txt');

    expect($response->getContent())->toContain('User-agent: *');
});

it('robots.txt disallows private paths', function () {
    $content = $this->get('/robots.txt')->getContent();

    foreach (['/admin', '/profile', '/checkout', '/login', '/register', '/forgot-password', '/reset-password', '/stripe', '/lang'] as $path) {
        expect($content)->toContain('Disallow: '.$path);
    }
});

it('robots.txt includes sitemap URL', function () {
    $content = $this->get('/robots.txt')->getContent();

    expect($content)->toContain('Sitemap: '.config('app.url').'/sitemap.xml');
});
