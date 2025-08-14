<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chatbot;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.allUsers');
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
