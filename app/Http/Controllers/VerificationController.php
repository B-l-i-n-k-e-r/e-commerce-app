<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Verified; // Import the Verified event

class VerificationController extends Controller
{
    /**
     * Mark the user's email address as verified.
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse // Changed to 'verify'
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user())); // Fire the Verified event
        }

        return redirect()->intended('/dashboard')->with('verified', true);
    }

    /**
     * Send the email verification notification.
     */
    public function resend(Request $request) // Changed to 'resend'
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
