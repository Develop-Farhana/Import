<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function validate_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        return redirect('login')->with('error', 'Login details are not valid');
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('admin.dashboard');
        }

        return redirect('login')->with('error', 'You are not allowed to access');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
