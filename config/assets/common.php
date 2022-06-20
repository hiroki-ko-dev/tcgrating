<?php

return [
    'appEnv' => env('APP_ENV'),

    'stripe' => [
        'pk_key' => env('STRIPE_PUBLIC_KEY'),
        'sk_key' => env('STRIPE_SECRET_KEY'),
    ],
];
