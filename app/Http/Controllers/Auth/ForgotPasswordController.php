<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\Notification;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Override to log email in DB
     */
    public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $response = Password::sendResetLink($request->only('email'));

    if ($response === Password::RESET_LINK_SENT) {
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user) {
            $token = Password::getRepository()->create($user);
            $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));

            Notification::create([
                'to_email' => $request->email,
                'subject' => 'Reset Password Notification',
                'body' => 'You are receiving this email because we received a password reset request for your account. Reset link: ' . $resetUrl,
                'type' => 'password_reset',
                'notifiable_type' => get_class($user),
                'notifiable_id' => $user->id,
            ]);
        }

        return back()->with('status', __($response));
    }

    return back()->withErrors(['email' => __($response)]);
}
}
