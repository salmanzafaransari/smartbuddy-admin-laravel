<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Chatbot;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.allUsers');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:8',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.'
            ], 422);
        }

        // Update password and timestamp
        $user->password = Hash::make($request->new_password);
        $user->password_changed_at = now();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.'
        ]);
    }

    public function getUsers(Request $request)
    {
        $users = User::where('is_superuser', false)
        ->select('id', 'first_name', 'last_name', 'profile_photo', 'email', 'last_login_at', 'created_at')
        ->withCount('chatbots') 
        ->get();

        return response()->json(['data' => $users]);
    }
    public function countUsers(Request $request)
    {
        $totalUsers = User::where('is_superuser', false)->count();

        return response()->json(['data' => $totalUsers]);
    }
    public function tracker(){
        return view('admin.tracker');
    }
}
