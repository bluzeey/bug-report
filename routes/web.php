<?php

use App\Http\Controllers\PaddleController;
use App\Http\Controllers\SocialLoginController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/billing',[PaddleController::class,'showBilling'])->name('billing');
});

Route::get('paddle/checkout/{priceId}',[PaddleController::class,'checkout'])->name('checkout.paddle');

Route::get('auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback']);

Route::get('auth/outlook', [SocialLoginController::class, 'redirectToOutlook'])->name('auth.outlook');
Route::get('auth/outlook/callback', [SocialLoginController::class, 'handleOutlookCallback']);
