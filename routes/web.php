<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscriptionController;

// Landing page
Route::get('/', [HomeController::class, 'landing'])->name('landing');

// home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// auth
Route::get('/login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
Route::post('/login', [AuthController::class, 'doLogin'])->middleware('guest');
Route::delete('/logout', [AuthController::class, 'doLogout'])->name('auth.logout')->middleware('auth');

Route::get('/register', [AuthController::class, 'register'])->name('auth.register')->middleware('guest');
Route::post('/register', [AuthController::class, 'doRegistration'])->middleware('guest');

Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('password.forgot')->middleware('guest');
Route::post('/forgot-password', [AuthController::class, 'sendForgot'])->middleware('guest');

Route::get('/reset-password/{token}', [AuthController::class, 'reset'])->name('password.reset')->middleware('guest');

Route::post('/reset-password', [AuthController::class, 'doReset'])->name('password.update')->middleware('guest');

// trip
Route::get('/trip/create', [TripController::class, 'create'])->name('trip.create')->middleware('auth');
Route::get('/trip/{trip}/edit', [TripController::class, 'edit'])->name('trip.edit')->middleware('auth');
Route::post('/trip/create', [TripController::class, 'store'])->middleware('auth');
Route::put('/trip/{trip}/edit', [TripController::class, 'update'])->middleware('auth');
Route::put('/trip/{trip}/visibility', [TripController::class, 'visibility'])->name('trip.visibility')->middleware('auth');
Route::put('/trip/{trip}/participate', [TripController::class, 'participate'])->name('trip.participate')->middleware('auth');
Route::get('/trip/{trip}/show', [TripController::class, 'show'])->name('trip.show');
Route::delete('/trip/{trip}/destroy', [TripController::class, 'destroy'])->name('trip.destroy')->middleware('auth');
Route::get('/trip/{trip}/rate', [TripController::class, 'rate'])->name('trip.rate')->middleware('auth');
Route::post('/trip/{trip}/rate', [TripController::class, 'doRating'])->middleware('auth');

// search
Route::get('/trip/search', [SearchController::class, 'doSearch'])->name('trip.search');

// profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::get('/profile/trips', [ProfileController::class, 'trips'])->name('profile.trips')->middleware('auth');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile/edit', [ProfileController::class, 'update'])->middleware('auth');
Route::get('/profile/{user}/show', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/invoices', [ProfileController::class, 'invoices'])->name('profile.invoices')->middleware('auth');

// invoice
Route::get('/invoice/{invoice}/download', [InvoiceController::class, 'download'])->name('invoice.download')->middleware('auth');

// subscription
// Route::get('/premium', [SubscriptionController::class, 'pricing'])->name('subscription.pricing')->middleware(['notSubscribed']);
// Route::post('/premium', [SubscriptionController::class, 'subscribe'])->middleware(['auth', 'notSubscribed']);
// Route::get('/confirmation', [SubscriptionController::class, 'confirmation'])->name('subscription.confirmation')->middleware(['auth', 'subscribed']);
// Route::delete('/unsubscribe', [SubscriptionController::class, 'cancel'])->name('subscription.cancel')->middleware(['auth', 'subscribed']);
