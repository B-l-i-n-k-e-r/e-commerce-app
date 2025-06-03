<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TestNotification extends Notification
{
    public function via($notifiable)
    {
        return ['database']; // Store in database only
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'This is a test notification!',
        ];
    }
}
