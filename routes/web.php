<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TravelRecordController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\ContactController;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/booking', function () {
        return view('profile.booking');
    })->name('profile.booking');
});

require __DIR__ . '/auth.php';

Route::prefix('admin')->name('admin.')->group(function () {
    // Menampilkan Form Login (GET) -> akses: /admin/login
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');

    // Proses Submit Login (POST)
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    // Proses Logout Admin (POST)
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// GROUP ADMIN (Semua route di dalam ini diproteksi Middleware)
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Manage Product (CRUD)
    Route::resource('products', ProductController::class);

    // 3. Track Record (CRUD)
    Route::resource('travel-records', TravelRecordController::class);

    // 4. Booking List (Biasanya cuma butuh index & show/update)
    Route::resource('bookings', BookingController::class);

    // 5. Messages (Biasanya cuma index & destroy)
    Route::resource('messages', MessageController::class);
});

// Route untuk memproses kirim pesan (POST)
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::resource('messages', MessageController::class);