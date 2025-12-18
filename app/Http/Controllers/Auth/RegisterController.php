<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }



    /**
     * Show the registration form depending on the route
     */
    public function showRegistrationForm()
    {
        if (request()->routeIs('admin.register.form')) {
            return view('auth.admin_register'); // Create this Blade for admin
        }

        if (request()->routeIs('customer.register.form')) {
            return view('auth.customer_register'); // Your existing customer registration Blade
        }

        return view('auth.customer_register'); // fallback
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    
        // Assign role based on route
        if (request()->routeIs('admin.register')) {
            $user->assignRole('Admin');
        } else {
            $user->assignRole('Customer');
        }

        return $user;
    }  
    
    /**
     * Redirect the user on the basis of their role after registration
     */

    protected function registered($request, $user)
    {
        if ($user->hasRole('Admin')) {
            return redirect('/admin/dashboard');
        }

        if ($user->hasRole('Manager')) {
            return redirect('/manager/dashboard');
        }
        
        if ($user->hasRole('Customer')) {
            return redirect('/customer/dashboard');
        }

        return redirect('/login');
    }
}
