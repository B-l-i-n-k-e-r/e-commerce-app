<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSent;
use App\Models\Notification;

class LogSentEmail
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Mail\Events\MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        $message = $event->sent->getOriginalMessage();

        // Extract subject
        $subject = $message->getSubject();

        // Extract "To" emails (handling the address objects)
        $toAddresses = $message->getTo();
        $to = implode(', ', array_map(fn($address) => $address->getAddress(), $toAddresses));

        /**
         * FIX: Extracting the body content as a string.
         * Using getHtmlBody() or getTextBody() ensures we get the actual string content
         * instead of the Symfony Part object.
         */
        $body = $message->getHtmlBody() ?: $message->getTextBody();

        // Store into your notifications table
        Notification::create([
            'to_email' => $to,
            'subject'  => $subject,
            'body'     => $body,
        ]);
    }
}