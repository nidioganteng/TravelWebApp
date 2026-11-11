<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TravelRecordController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\UserController;
use App\Models\Booking;
use App\Models\TrackRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id', 'nl', 'de', 'pt'])) {
        session()->put('locale', $locale);
    }

    return redirect()->back();
})->middleware('throttle:30,1')->name('lang.switch');

Route::get('/', function () {
    return view('front.home');
})->name('home');

Route::get('/about', function (Request $request) {
    if ($request->has('year')) {
        $selectedYear = $request->year;
    } else {
        $selectedYear = 2025;
    }

    $query = TrackRecord::query();

    if ($selectedYear) {
        $query->where('year', $selectedYear);
    }

    $trackRecords = $query->latest()->get();
    $availableYears = range(date('Y'), 2018);

    return view('front.about', compact('trackRecords', 'availableYears', 'selectedYear'));
})->name('about');

Route::get('/track-record/{slug}', function ($slug) {
    $record = TrackRecord::with('items')->where('slug', $slug)->firstOrFail();

    return view('front.show', compact('record'));
})->name('track-record.show');

Route::get('/products', [UserController::class, 'index'])->name('products');

Route::get('/contact', function () {
    return view('front.contact');
})->name('contact');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/booking', function () {
        $activeBookings = auth()->user()
            ->bookings()
            ->with(['product', 'participants'])
            ->where('status', 'paid')
            ->latest()
            ->get();

        $unpaidBookings = auth()->user()
            ->bookings()
            ->with('product')
            ->where('status', 'unpaid')
            ->latest()
            ->get();

        return view('profile.booking', compact('activeBookings', 'unpaidBookings'));
    })->name('profile.booking');

    Route::post('/profile/booking/{booking}/repay', [CheckoutController::class, 'repay'])->middleware('throttle:10,1')->name('profile.booking.repay');

    Route::delete('/profile/booking/{booking}/cancel', function (Booking $booking) {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'unpaid') {
            return back()->withErrors(['error' => 'Only unpaid bookings can be cancelled.']);
        }

        $booking->delete();

        return back()->with('success', 'Booking has been cancelled successfully.');
    })->name('profile.booking.cancel');
});

require __DIR__.'/auth.php';

// GROUP ADMIN (Semua route di dalam ini diproteksi Middleware)
Route::middleware(['admin', 'throttle:60,1'])->prefix('admin')->name('admin.')->group(function () {

    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Manage Product (CRUD)
    Route::resource('products', ProductController::class); // Ini sudah mencakup index, create, store, edit, update, destroy
    Route::post('/products/{id}/publish', [ProductController::class, 'publish'])->name('products.publish');
    Route::patch('/products/{product}/toggle', [ProductController::class, 'togglePublish'])
        ->name('products.toggle');

    // 3. Track Record (CRUD)
    Route::resource('travel-records', TravelRecordController::class);

    // 4. Booking List (Biasanya cuma butuh index & show/update)
    Route::resource('bookings', BookingController::class);

    // 5. Messages (Biasanya cuma index & destroy)
    Route::resource('messages', MessageController::class);
    Route::post('/messages/{id}/mark-as-read', [MessageController::class, 'markAsRead'])->name('messages.read');

    // 6. User Activity Log
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
});

// Route untuk memproses kirim pesan (POST)
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:3,10')->name('contact.store');

// Checkout Routes (auth protected)
Route::middleware('auth')->group(function () {
    Route::get('/checkout/{product}/details', [CheckoutController::class, 'details'])->name('checkout.details');
    Route::post('/checkout/{product}', [CheckoutController::class, 'process'])->middleware('throttle:10,1')->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});

// Stripe Webhook (tidak pakai auth/CSRF - dipanggil oleh server Stripe)
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');
