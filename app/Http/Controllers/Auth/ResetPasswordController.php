<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * redirect user after password successfully reset.
     */
    protected function redirectTo()
    {
        $user = auth->user();

        if ($user->hasRole('Admin')) {
            return '/admin/dashboard';
        }

        if ($user->hasRole('Manager')) {
            return '/manager/dashboard';
        }

        if ($user->hasRole('Customer')) {
            return '/customer/dashboard';
        }

        return '/';
    }
}
