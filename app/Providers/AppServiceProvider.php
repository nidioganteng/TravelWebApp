<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade; // <--- Baris ini sering lupa dicopy, fatal akibatnya!

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   
        // dd('Kodingan ini jalan!');
        // Kode ini memaksa Laravel menganggap folder 'resources/views/layouts'
        // sebagai komponen dengan nama awalan 'layouts.'
        \Illuminate\Support\Facades\Blade::component('layouts.app', 'main');
    }
}