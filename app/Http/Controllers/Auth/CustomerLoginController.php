<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomerLoginController extends Controller
{
    use AuthenticatesUsers;

    // After customer login → redirect to customer dashboard
    protected $redirectTo = '/shop/index';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle the login for customers only
     */
    public function customerLogin(Request $request)
    {
        // Validate fields
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Try login
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {

            $user = Auth::user();

            // Allow only customers
            // if ($user->hasRole('Customer')) {
            //     return redirect()->route('shop.index');
            // }




            if ($user->hasRole('Customer')) {

                // -----------------------------
                // Merge Guest Cart with User Cart
                // -----------------------------
                $guestCart = session('cart', []);

                // Optional: Load user cart from DB if you have one
                // $userCart = ...;

                // Merge carts (simple approach: overwrite with guest cart)
                session(['cart' => $guestCart]);

                // Update cart_count in session
                session(['cart_count' => collect($guestCart)->sum('quantity')]);

                return redirect()->route('shop.index');
            }



            // If user is not a customer → logout and show error
            Auth::logout();
            return back()->withErrors(['email' => 'You are not authorized as a customer.']);
        }

        // If credentials invalid
        return back()->withErrors(['email' => 'Invalid email or password.']);
    }
}
