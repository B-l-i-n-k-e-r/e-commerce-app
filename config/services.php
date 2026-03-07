<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

 'mailtrap' => [
    'host' => env('MAILTRAP_HOST', 'mailtrap.io'),  // default to mailtrap.io
    'token' => env('MAILTRAP_API_TOKEN'),
    'inbox_id' => env('MAILTRAP_INBOX_ID'),
],

// ... other services like slack and mailtrap

    'mpesa' => [
        'key' => env('MPESA_CONSUMER_KEY'),
        'secret' => env('MPESA_CONSUMER_SECRET'),
        'shortcode' => env('MPESA_SHORTCODE'),
        'passkey' => env('MPESA_PASSKEY'),
        'callback' => env('MPESA_CALLBACK_URL'),
        'env' => env('MPESA_ENVIRONMENT', 'sandbox'),
    ],

]; // End of file
