<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Redirect berdasarkan role
            $user = Auth::user();
            if ($user->role === 'tim_sakip') {
                return redirect()->route('dashboard.tim_sakip');
            } elseif ($user->role === 'unit_kerja') {
                return redirect()->route('dashboard.unit_kerja');
            } elseif ($user->role === 'evaluator') {
                return redirect()->route('dashboard.evaluator');
            }
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}