<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show vendor login form
     */
    public function showLoginForm()
    {
        return view('vendor.auth.login');
    }

    /**
     * Handle vendor login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('vendor')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('vendor.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid vendor credentials.',
        ]);
    }

    /**
     * Vendor logout
     */
    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('vendor.login');
    }
}
