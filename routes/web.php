<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ChatbotApiController;
use App\Http\Controllers\UserController;

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
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('editProfile');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/setting', [ProfileController::class, 'setting'])->name('setting');

    Route::post('/account/send-delete-code', [ProfileController::class, 'sendDeleteCode'])->name('account.sendDeleteCode');
    Route::post('/account/delete', [ProfileController::class, 'deleteAccount'])->name('account.delete');

    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
    Route::post('/chatbots', [ChatbotController::class, 'store'])->name('chatbot.store');
    Route::delete('/chatbot/{id}', [ChatbotController::class, 'destroy'])->name('chatbot.destroy');
    Route::get('/chatbot/{id}/edit', [ChatbotController::class, 'edit'])->name('chatbot.edit');
    Route::put('/chatbot/{id}', [ChatbotController::class, 'update'])->name('chatbot.update');
    Route::get('/chatbot/{id}/configure', [ChatbotController::class, 'configure'])->name('chatbot.configure');
    Route::post('/chatbot/{id}/generate-token', [ChatbotApiController::class, 'generateToken'])->name('chatbot.generateToken');
    // Route::get('/chatbot/customize', [ChatbotController::class, 'customize']);
    Route::post('/chatbot/customize', [ChatbotController::class, 'saveBot'])->name('chatbot.customize');
    // Route::get('/chatbot/{id}/check-token',[ChatbotController::class, 'checkToken']);
    
});

// for super user

Route::middleware(['auth', 'superuser'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/admin/users/list', [UserController::class, 'getUsers'])->name('users.list');
    Route::get('/admin/users/count', [UserController::class, 'countUsers'])->name('users.count');
    Route::get('/admin/track', [UserController::class, 'tracker'])->name('users.track');
});



// log in route start from here
// Show login form
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Handle login request
Route::post('/login', [LoginController::class, 'login']);
// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// for forgot and reset password
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

//login with google route start from here
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Route::get('/log-in', function () {
//     return view('log-in')->name('login');
// });