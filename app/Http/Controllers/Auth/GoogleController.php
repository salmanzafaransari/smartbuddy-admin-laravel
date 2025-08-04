<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class GoogleController extends Controller
{
   public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $fullName = $googleUser->getName();
        $nameParts = explode(' ', $fullName);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

        $existingUser = User::where('email', $googleUser->getEmail())->first();

        $newPhotoPath = null;

        if (!$existingUser || ($existingUser->profile_photo && str_contains($existingUser->profile_photo, 'google_'))) {
            // Download new Google photo only if:
            // - User doesn't exist, OR
            // - Existing photo is a Google image
            $avatarUrl = $googleUser->getAvatar();
            $avatarContents = file_get_contents($avatarUrl);
            $fileName = 'google_' . Str::random(10) . '.jpg';
            $storagePath = public_path('assets/images/' . $fileName);

            // Delete old google photo if exists
            if ($existingUser && File::exists(public_path($existingUser->profile_photo))) {
                File::delete(public_path($existingUser->profile_photo));
            }

            File::put($storagePath, $avatarContents);
            $newPhotoPath = 'assets/images/' . $fileName;
        }

        // Create or update the user without overriding manually uploaded profile photos
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'password' => bcrypt(Str::random(24)),
                'email_verified_at' => now(),
                'profile_photo' => $newPhotoPath ?? $existingUser->profile_photo,
            ]
        );

        Auth::login($user);
        return redirect()->route('dashboard');
    }
}
