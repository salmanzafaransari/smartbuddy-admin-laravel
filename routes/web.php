<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\LoginController;


// Auth::routes(['verify' => true]);

// dasboard urls
Route::get('/sign-up', [RegisterController::class, 'showForm'])->name('signup');
Route::post('/register', [RegisterController::class, 'register'])->name('register.signup');

// Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email'); // Create this view
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard'); // After verification success
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/dashboard', function () {
     return view('home');
})->middleware(['auth', 'verified']);

// log in route start from here

// Show login form
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Handle login request
Route::post('/login', [LoginController::class, 'login']);
// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/log-in', function () {
//     return view('log-in')->name('login');
// });