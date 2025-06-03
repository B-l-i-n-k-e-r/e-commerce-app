<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use App\Models\User; // Add this if using User model
use Illuminate\Support\Facades\Notification; // Add this if using notifications

class PasswordResetLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest'); // <<< CRITICAL ADDITION
    }

    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'email' => ['required', 'email', 'exists:users'],
    ]);

    $user = User::where('email', $request->email)->first();

    // If admin approval is required
    if (config('auth.password_reset_requires_admin')) {
        $user->update(['password_reset_requested_at' => now()]);
        Notification::send(User::admins()->get(), new AdminPasswordResetRequest($user));
        
        return back()->with('status', 'Password reset request submitted for admin approval');
    }

    // Standard reset flow
    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status == Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
}
}