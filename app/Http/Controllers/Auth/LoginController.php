<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.log-in'); // Your custom login Blade
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->back()->withErrors(['email' => 'Please verify your email before logging in.']);
            }

            return redirect()->intended('/dashboard')->with('success', 'Logged in successfully!');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
