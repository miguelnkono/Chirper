<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Registration;
use App\Http\Controllers\ChirpController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChirpController::class, 'index']);
Route::middleware('auth')
    ->group(function () {
        Route::resource('/chirps', ChirpController::class)
            ->only(['store', 'edit', 'update', 'destroy']);
    });

// registration route
Route::view('/register', 'auth.registration')
    ->middleware('guest')
    ->name('register');

Route::post('/register', Registration::class)->middleware('guest');

Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::post('/login', Login::class)
    ->middleware('guest');

Route::post('/logout', Logout::class)
    ->middleware('auth');
