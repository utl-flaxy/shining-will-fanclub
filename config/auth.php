<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Authentication Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify which authentication guard and password reset
    | options should be used by default for your application.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | A default configuration has been defined for you here which uses
    | session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how
    | the users are actually retrieved out of your database or other
    | storage mechanisms used by this application to persist your
    | user's data.
    |
    | Supported drivers: "session", "token"
    |
    */

    'guards' => [
        // 通常のWebログイン用
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Filament管理画面用（webを利用するのが基本）
        'admin' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how
    | the users are actually retrieved out of your database or other
    | storage mechanisms used by this application to persist your user's
    | data.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Settings
    |--------------------------------------------------------------------------
    |
    | Here you may set the options for resetting passwords including the
    | view that your password reset e-mail is sent from. You may also
    | set the name of the table that maintains all of the reset tokens.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60, // minutes
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password
    | confirmation times out and the user is prompted to re-enter
    | their password. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];
