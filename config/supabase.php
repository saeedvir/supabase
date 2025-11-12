<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Supabase Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Supabase connection settings.
    |
    */

    'url' => env('SUPABASE_URL', ''),

    'key' => env('SUPABASE_KEY', ''),

    'secret' => env('SUPABASE_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Supabase Services
    |--------------------------------------------------------------------------
    |
    | Configure which Supabase services you want to enable.
    |
    */

    'services' => [
        'auth' => true,
        'database' => true,
        'storage' => true,
        'realtime' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the HTTP client settings for Supabase requests.
    |
    */

    'http' => [
        'timeout' => 30,
        'retries' => 3,
    ],
];