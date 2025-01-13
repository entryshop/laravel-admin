<?php

return [
    'prefix' => 'admin',
    'auth'   => [
        'guards'    => [
            'admin' => [
                'driver'   => 'session',
                'provider' => 'admin_users',
            ],
        ],
        'providers' => [
            'admin_users' => [
                'driver' => 'eloquent',
                'model'  => env('AUTH_MODEL', App\Models\User::class),
            ],
        ],
    ],
];
