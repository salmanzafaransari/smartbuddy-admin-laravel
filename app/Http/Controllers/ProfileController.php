<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProfileController extends Controller
{
   public function edit()
    {
        return view('profile.edit-profile');
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->update($request->only('first_name', 'last_name', 'phone', 'company', 'job_title', 'location', 'bio'));

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $filename);
            $user->profile_photo = 'assets/images/' . $filename;
            $user->save();
        }

        return redirect()->route('editProfile')->with('success', 'Profile updated successfully.');
    }
    public function profile(){
       $user = auth()->user();
        $lastLoginAt = $user->last_login_at;

        $formattedLogin = 'Never logged in';

        if ($lastLoginAt) {
            $loginTime = Carbon::parse($lastLoginAt)->timezone('Asia/Kolkata');
            $now = Carbon::now('Asia/Kolkata');

            if ($loginTime->isToday()) {
                $prefix = 'Today';
            } elseif ($loginTime->isYesterday()) {
                $prefix = 'Yesterday';
            } elseif ($loginTime->diffInDays($now) <= 7) {
                $prefix = $loginTime->diffForHumans(); // "3 days ago"
            } else {
                $prefix = $loginTime->format('F j, Y'); // "August 2, 2025"
            }

            $formattedLogin = $prefix . ' at ' . $loginTime->format('g:i A');
        }

        return view('profile.profile', [
            'formattedLogin' => $formattedLogin,
        ]);
    }
}
