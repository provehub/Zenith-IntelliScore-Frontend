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
    
    'termii' => [
        'api_key' => env('TERMII_API_KEY'),
        'sender_id' => env('TERMII_SENDER_ID'),
        'baseUrl' => 'https://v3.api.termii.com',
    ],

    'fcm' => [
        'server_key' => env('FCM_SERVER_KEY'),
        'project_id' => env('FCM_PROJECT_ID'),
    ],
    'agora' => [
        'agora_app_id' => env('AGORA_APP_ID'),
        'agora_app_certificate' => env('AGORA_APP_CERTIFICATE'),
    ],
    'provehub' => [
        'queue_key' => env('PROVEHUB_QUEUE_KEY'),
    ],
    'onesignal' => [
    'app_id'            => env('ONESIGNAL_APP_ID'),
    'rest_api_key'      => env('ONESIGNAL_REST_API_KEY'),
    'user_auth_key'     => env('ONESIGNAL_USER_AUTH_KEY', ''), // optional
    'api_url'           => env('ONESIGNAL_API_URL', 'https://onesignal.com/api/v1'),
    ],


];
