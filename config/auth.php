<?php

return [
    'defaults' => [
        'guard' => 'user',
        'passwords' => 'admin',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
            'hash' => false,
        ],
        'admin' => [
            'driver' => 'passport',
            'provider' => 'admin',
        ],
        'user' => [
            'driver' => 'passport',
            'provider' => 'users',
        ]
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
            'hash' => true,
            'table' => 'users',
        ],
        'admin' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ]
    ],

    /*
            |--------------------------------------------------------------------------
            | Password Confirmation Timeout
            |--------------------------------------------------------------------------
            |
            | Here you may define the amount of seconds before a password confirmation
            | times out and the user is prompted to re-enter their password via the
            | confirmation screen. By default, the timeout lasts for three hours.
            |
    */

    'password_timeout' => 10800,
];