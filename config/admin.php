<?php

return [
    'routes_enabled' => true,
    'default'        => 'default',
    'prefix'         => 'admin',
    'as'             => 'admin.',
    'languages'      => [
        'en'    => 'English',
        'zh_CN' => '简体中文',
    ],
    'auth'           => [
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
