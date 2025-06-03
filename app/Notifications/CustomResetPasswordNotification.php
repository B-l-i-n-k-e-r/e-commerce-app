<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class CustomResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Keep 'database' here for now
    }

    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset Password Notification')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $resetUrl)
            ->line('If you did not request a password reset, no further action is required.');
    }

    public function toDatabase($notifiable)
    {
        $mailMessage = $this->toMail($notifiable);

        $dataToStore = [
            'subject' => $mailMessage->subject,
            'body_html' => $mailMessage->render(), // THIS IS THE LINE WE SUSPECT
            'reset_link' => url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false)),
        ];

        // DUMP AND DIE HERE TO INSPECT THE DATA
        dd(
            'toDatabase is being called!',
            'Subject type: ' . gettype($dataToStore['subject']),
            'Body HTML type: ' . gettype($dataToStore['body_html']),
            'Reset Link type: ' . gettype($dataToStore['reset_link']),
            $dataToStore
        );

        return $dataToStore;
    }
}