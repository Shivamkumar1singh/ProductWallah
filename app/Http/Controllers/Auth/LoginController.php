<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override login logic to allow only admin and manager roles
     */
    public function login(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Attempt login using default guard
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {

            $user = Auth::user();

            // Allow only admin or manager
            if ($user->hasRole('Admin') || $user->hasRole('Manager')) {
                return redirect()->route('admin.dashboard');
            }

            // If not admin/manager → logout & show error
            Auth::logout();
            return back()->withErrors(['email' => 'You are not authorized as an admin or manager.']);
        }

        // If login failed
        return back()->withErrors(['email' => 'Invalid email or password.']);
    }
}
