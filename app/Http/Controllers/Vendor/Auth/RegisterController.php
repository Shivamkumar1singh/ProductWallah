<?php

namespace App\Http\Controllers\Vendor\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;


class RegisterController extends Controller
{
    public function showRegistration()
    {
        return view('vendor.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:vendors',
            'password' => 'required|min:6|confirmed',
        ]);

        $vendor = Vendor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Always hash passwords
        ]);

        Auth::guard('vendor')->login($vendor);

        return redirect()->route('vendor.dashboard');
    }
}
