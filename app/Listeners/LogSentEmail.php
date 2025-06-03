<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSent;
use App\Models\Notification;

class LogSentEmail
{
    public function handle(MessageSent $event)
    {
        $message = $event->message;

        // Extract subject and to email(s)
        $subject = $message->getSubject();
        $to = implode(', ', array_keys($message->getTo()));

        // Extract the body as string (simplified)
        $body = $message->getBody();

        // Store into your notifications table
        Notification::create([
            'to_email' => $to,
            'subject' => $subject,
            'body' => $body,
        ]);
    }
}

