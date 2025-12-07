<?php

return [

    'invite_only' => false,

    'broadcasting' => [
        'echo' => false,
        'connection' => env('BROADCAST_DRIVER', 'log'),
    ],

    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),

    'default_avatar_provider' => null,

    'auth' => [
        'guard' => 'web',
        'pages' => [
            'login' => \Filament\Pages\Auth\Login::class,
        ],
    ],

    'middleware' => [
        'base' => [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'auth' => [
            \Filament\Http\Middleware\Authenticate::class,
        ],
    ],

    'assets' => [],

];
