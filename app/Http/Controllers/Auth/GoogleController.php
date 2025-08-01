<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
   public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $fullName = $googleUser->getName(); // e.g., "Salman Zafar"
        $nameParts = explode(' ', $fullName);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'password' => bcrypt(Str::random(24)),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user);
        return redirect()->route('dashboard');
    }
}
