<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | Credentials for third-party integrations (Mailgun, SES, Stripe, etc.)
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Stripe
    |--------------------------------------------------------------------------
    |
    | Stripe Secret Key & Webhook Secret
    | STRIPE_WEBHOOK_SECRET は Stripe CLI または本番の Webhook 設定から取得。
    |
    */

    'stripe' => [
        'secret'         => env('STRIPE_SECRET'),          // ← あなたの STRIPE_SECRET
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),  // ← Webhook 署名シークレット
    ],

];
