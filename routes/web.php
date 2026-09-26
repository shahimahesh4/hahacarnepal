<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', function () {
    return view('home');
})->name('home');

// Direct Vehicle Booking (SIXT-style direct rental with chauffeur/self-drive)
Route::get('/book-vehicle', function () {
    return view('book');
})->name('book.index');

Route::redirect('/book', '/book-vehicle');

Route::get('/booking/{reference}', function ($reference) {
    return view('booking-show', ['reference' => $reference]);
})->name('booking.show');

// Customer Authentication & Dashboard
Route::get('/customer/login', function () {
    return view('customer-login');
})->name('customer.login');

Route::get('/customer/register', function () {
    return view('customer-register');
})->name('customer.register');

Route::get('/customer/dashboard', function () {
    return view('customer-dashboard');
})->name('customer.dashboard');

Route::get('/customer/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('home');
})->name('customer.logout');

// Partner Driver & Fleet Onboarding
Route::get('/partner/register', function () {
    return view('partner-register');
})->name('partner.register');

Route::get('/partner/dashboard', function () {
    return view('partner-dashboard');
})->name('partner.dashboard');

// Metasearch Aggregator
Route::get('/search', function () {
    return view('search');
})->name('search.index');

// Signed Outbound Partner Redirect with Attribution
Route::get('/go/{offer}', RedirectController::class)->name('go.redirect');

// Price Alerts & Newsletters
Route::get('/alerts/confirm/{token}', [AlertController::class, 'confirm'])->name('alerts.confirm');
Route::get('/alerts/unsubscribe/{token}', [AlertController::class, 'unsubscribe'])->name('alerts.unsubscribe');
Route::get('/newsletter/unsubscribe', [\App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Support & FAQs
Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact.index');

Route::get('/faq', function () {
    return view('pages.faq');
})->name('faq.index');

// CMS Pages (About, How It Works, Legal)
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
