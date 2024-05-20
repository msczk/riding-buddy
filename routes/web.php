<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\Auth\AuthController;

// home
Route::get('/', [HomeController::class, 'show'])->name('home');

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

Route::get('/trip/{trip}/show', [TripController::class, 'show'])->name('trip.show');