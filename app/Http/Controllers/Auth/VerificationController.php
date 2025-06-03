<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Override resend method to add logging to notifications table.
     */
    public function resend(Request $request)
{
    Log::info('📨 Resend verification route was triggered');

    if ($request->user()->hasVerifiedEmail()) {
        Log::info('✅ User already verified, redirecting.');
        return redirect($this->redirectPath());
    }

    $request->user()->sendEmailVerificationNotification();
    Log::info('✅ Verification email sent to: ' . $request->user()->email);

    try {
        Notification::create([
            'to_email' => $request->user()->email,
            'subject' => 'Verify Your Email',
            'body' => 'Verification email sent. Please check your inbox.',
        ]);
        Log::info('✅ Notification saved to database.');
    } catch (\Exception $e) {
        Log::error('❌ Failed to save notification: ' . $e->getMessage());
    }

    return back()->with('status', 'verification-link-sent');
}
}
