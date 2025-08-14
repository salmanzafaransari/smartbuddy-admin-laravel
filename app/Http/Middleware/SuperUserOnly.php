<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class SuperUserOnly
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->is_superuser) {
            // Destroy session and log out
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect to login with message
            return redirect()->route('login')
                ->withErrors(['auth' => 'Unauthorized access.']);
        }

        return $next($request);
    }
}
