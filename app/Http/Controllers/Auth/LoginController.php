<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Remove this line since we're customizing redirection
    // protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Determine where to redirect users after login.
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            return '/admin';
        }

        // Assuming you have a column like 'last_login_at' in your users table
        if (is_null($user->last_login_at)) {
            return '/home';
        }

        return '/dashboard';
    }

    /**
     * After authentication, update last login timestamp.
     */
    protected function authenticated($request, $user)
    {
        $user->last_login_at = now();
        $user->save();
    }
}
