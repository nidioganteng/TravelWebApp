<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.env') === 'production') {
            if (! $request->secure()) {
                return redirect()->secure($request->getRequestUri(), 301);
            }

            $appHost = parse_url(config('app.url'), PHP_URL_HOST);
            if ($appHost && $request->getHost() !== $appHost) {
                $url = rtrim(config('app.url'), '/').$request->getRequestUri();

                return redirect($url, 301);
            }
        }

        return $next($request);
    }
}
