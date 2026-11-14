<?php

use App\Http\Middleware\ForceHttps;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

function makeForceHttpsRequest(string $uri = '/', string $host = 'example.com', bool $secure = false): Request
{
    $scheme = $secure ? 'https' : 'http';

    return Request::create("{$scheme}://{$host}{$uri}");
}

it('passes through when not in production', function () {
    config(['app.env' => 'local', 'app.url' => 'http://localhost']);

    $request = makeForceHttpsRequest('/', 'localhost', false);
    $middleware = new ForceHttps;

    $response = $middleware->handle($request, fn ($req) => new Response('ok'));

    expect($response->getContent())->toBe('ok');
});

it('redirects HTTP to HTTPS in production', function () {
    config(['app.env' => 'production', 'app.url' => 'https://example.com']);

    $request = makeForceHttpsRequest('/page', 'example.com', false);
    $middleware = new ForceHttps;

    $response = $middleware->handle($request, fn ($req) => new Response('ok'));

    expect($response->getStatusCode())->toBe(301)
        ->and($response->headers->get('Location'))->toContain('https://');
});

it('passes through when HTTPS and host matches in production', function () {
    config(['app.env' => 'production', 'app.url' => 'https://example.com']);

    $request = makeForceHttpsRequest('/', 'example.com', true);
    $middleware = new ForceHttps;

    $response = $middleware->handle($request, fn ($req) => new Response('ok'));

    expect($response->getContent())->toBe('ok');
});

it('redirects www to non-www when APP_URL has no www', function () {
    config(['app.env' => 'production', 'app.url' => 'https://example.com']);

    $request = makeForceHttpsRequest('/page', 'www.example.com', true);
    $middleware = new ForceHttps;

    $response = $middleware->handle($request, fn ($req) => new Response('ok'));

    expect($response->getStatusCode())->toBe(301)
        ->and($response->headers->get('Location'))->toContain('example.com')
        ->and($response->headers->get('Location'))->not->toContain('www.example.com');
});

it('redirects non-www to www when APP_URL has www', function () {
    config(['app.env' => 'production', 'app.url' => 'https://www.example.com']);

    $request = makeForceHttpsRequest('/page', 'example.com', true);
    $middleware = new ForceHttps;

    $response = $middleware->handle($request, fn ($req) => new Response('ok'));

    expect($response->getStatusCode())->toBe(301)
        ->and($response->headers->get('Location'))->toContain('www.example.com');
});
