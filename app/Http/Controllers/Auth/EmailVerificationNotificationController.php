<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Notification;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Send built-in verification email
        $request->user()->sendEmailVerificationNotification();

        // Log notification in DB
        Notification::create([
            'to_email' => $request->user()->email,
            'subject' => 'Verify Your Email',
            'body' => 'Verification email sent. Please check your inbox.',
            'type' => 'email_verification',
            'notifiable_type' => get_class($request->user()),
            'notifiable_id' => $request->user()->id,
        ]);

        return back()->with('status', 'verification-link-sent');
    }
}
