<?php

use Illuminate\Support\Facades\Route;

// Route Bahasa
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id', 'nl'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/', function () {
    return view('front.home');
})->name('home');

Route::get('/about', function () {
    return view('front.about');
})->name('about');

Route::get('/products', function () {
    return view('front.products');
})->name('products');

Route::get('/contact', function () {
    return view('front.contact');
})->name('contact');