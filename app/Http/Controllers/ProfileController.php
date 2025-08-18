<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\AccountDeletionCodeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\Chatbot;

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
            $destinationPath = public_path('assets/images');
            $newFilePath = 'assets/images/' . $filename;

            // Delete old profile photo if exists and is not default
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                // Optional: only delete if it's not a Google profile photo
                if (str_contains($user->profile_photo, 'google_') || str_contains($user->profile_photo, '_')) {
                    @unlink(public_path($user->profile_photo));
                }
            }

            // Move new file
            $file->move($destinationPath, $filename);

            // Save new path
            $user->profile_photo = $newFilePath;
            $user->save();
        }


        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
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
        $totalModels = Chatbot::where('user_id', $user->id)->count();
        $chatbots = Chatbot::where('user_id', Auth::id())
        ->withCount('logs') // counts total calls for each chatbot
        ->latest()
        ->get();
        $totalBotCalls = $chatbots->sum('logs_count');

        return view('profile.profile', [
            'formattedLogin' => $formattedLogin,
            'totalModels' => $totalModels,
            'totalBotCalls' => $totalBotCalls,
        ]);
    }
    public function setting()
    {
        $user = Auth::user();
        $lastChanged = $user->password_changed_at ?? $user->created_at;
        $daysAgo = Carbon::now()->diffInDays($lastChanged);
        return view('profile.setting', [
            'lastPasswordChange' => $daysAgo
        ]);
    }
    public function sendDeleteCode(Request $request){
        $code = rand(100000, 999999);
        session(['delete_code' => $code]);

        Mail::to($request->user()->email)
            ->send(new AccountDeletionCodeMail($code, $request->user()));

        return response()->json(['success' => true]);
    }
    public function deleteAccount(Request $request){
        if ($request->code != Session::get('delete_code')) {
            return response()->json(['success' => false, 'message' => 'Invalid confirmation code.']);
        }

        $user = $request->user();
        $user->delete();
        Session::forget('delete_code');

        return response()->json(['success' => true]);
    }
}
