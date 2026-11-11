<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Blade::component('layouts.app', 'main');

        if (app()->isProduction() && config('app.debug')) {
            Log::critical('APP_DEBUG is true in production. Disable it immediately to prevent information disclosure.');
        }
    }
}
