<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Show the simple password-only login page
    public function show()
    {
        return view('login');
    }

    // Handle password submit
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        // We only allow a single pre-seeded user (id=1)
        $user = User::find(1);

        if (! $user) {
            return back()->withErrors(['password' => "That's not the magic word... try again! 💕"]);
        }

        if (Hash::check($request->password, $user->password)) {
            Auth::loginUsingId($user->id);
            $request->session()->regenerate();
            return redirect()->intended('/celebrate');
        }

        return back()->withErrors(['password' => "That's not the magic word... try again! 💕"]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
