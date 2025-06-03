<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Mail\Events\MessageSent;
use App\Listeners\LogSentEmail;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings.
     */
    protected $listen = [
        MessageSent::class => [
            LogSentEmail::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }
}
