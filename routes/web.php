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
Route::get('/book', function () {
    return view('book');
})->name('book.index');

Route::get('/booking/{reference}', function ($reference) {
    return view('booking-show', ['reference' => $reference]);
})->name('booking.show');

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

// Price Alerts
Route::get('/alerts/confirm/{token}', [AlertController::class, 'confirm'])->name('alerts.confirm');
Route::get('/alerts/unsubscribe/{token}', [AlertController::class, 'unsubscribe'])->name('alerts.unsubscribe');

// Support & FAQs
Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact.index');

Route::get('/faq', function () {
    return view('pages.faq');
})->name('faq.index');

// CMS Pages (About, How It Works, Legal)
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
