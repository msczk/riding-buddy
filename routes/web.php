<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;

// home
Route::get('/', [HomeController::class, 'show'])->name('home');

//auth
Route::get('/login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
Route::post('/login', [AuthController::class, 'doLogin'])->middleware('guest');;
Route::delete('/logout', [AuthController::class, 'doLogout'])->name('auth.logout')->middleware('auth');;