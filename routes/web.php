<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;

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

// trip
Route::get('/trip/create', [TripController::class, 'create'])->name('trip.create')->middleware('auth');
Route::get('/trip/{trip}/edit', [TripController::class, 'edit'])->name('trip.edit')->middleware('auth');
Route::post('/trip/create', [TripController::class, 'store'])->middleware('auth');
Route::put('/trip/{trip}/edit', [TripController::class, 'update'])->middleware('auth');
Route::put('/trip/{trip}/visibility', [TripController::class, 'visibility'])->name('trip.visibility')->middleware('auth');
Route::put('/trip/{trip}/participate', [TripController::class, 'participate'])->name('trip.participate')->middleware('auth');
Route::get('/trip/{trip}/show', [TripController::class, 'show'])->name('trip.show');
Route::delete('/trip/{trip}/destroy', [TripController::class, 'destroy'])->name('trip.destroy')->middleware('auth');

// profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::get('/profile/trips', [ProfileController::class, 'trips'])->name('profile.trips')->middleware('auth');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile/edit', [ProfileController::class, 'update'])->middleware('auth');
Route::get('/profile/{user}/show', [ProfileController::class, 'show'])->name('profile.show');