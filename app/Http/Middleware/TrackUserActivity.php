<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && ! $request->ajax() && ! $this->isAssetRequest($request)) {
            $user = Auth::user();
            $cacheKey = 'track_activity_'.$user->id;

            if (! Cache::has($cacheKey)) {
                Cache::put($cacheKey, true, now()->addMinutes(5));
                $user->last_seen_at = now();
                $user->last_page = $request->path();
                $user->last_ip = $request->ip();
                $user->save();
            }
        }

        return $next($request);
    }

    private function isAssetRequest(Request $request): bool
    {
        return (bool) preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|ico|woff2?|ttf|eot)$/i', $request->path());
    }
}
