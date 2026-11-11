<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        if (app()->isProduction() && $request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Report-Only: periksa pelanggaran tanpa enforce dulu.
        // Sumber yang dipakai: Cloudflare Turnstile (challenges.cloudflare.com),
        // Font Awesome CDN (cdnjs.cloudflare.com), flag images (flagcdn.com),
        // Alpine.js + Vite dipaket lokal (self).
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' challenges.cloudflare.com",
            "style-src 'self' 'unsafe-inline' cdnjs.cloudflare.com",
            "img-src 'self' data: flagcdn.com",
            "font-src 'self' cdnjs.cloudflare.com",
            'frame-src challenges.cloudflare.com',
            "connect-src 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
        ]);

        $response->headers->set('Content-Security-Policy-Report-Only', $csp);

        return $response;
    }
}
