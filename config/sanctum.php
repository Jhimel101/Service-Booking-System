<?php

use Laravel\Sanctum\Sanctum;

return [

    /*
    |--------------------------------------------------------------------------
    | Stateful Domains
    |--------------------------------------------------------------------------
    |
    | Requests from these domains/hosts will receive stateful API authentication
    | cookies. Include all domains that access your API via frontend.
    |
    */
    'stateful' => array_filter(array_unique(array_merge(
        explode(',', env('SANCTUM_STATEFUL_DOMAINS', '')),
        [
            'localhost',
            'localhost:3000',
            '127.0.0.1',
            '127.0.0.1:8000',
            '::1',
            Sanctum::currentApplicationUrlWithPort(),
        ]
    ))),

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes
    |--------------------------------------------------------------------------
    |
    | Number of minutes until tokens expire. Null means never expire.
    | Affects only API tokens, not session cookies.
    |
    */
    'expiration' => env('SANCTUM_TOKEN_EXPIRATION', 60 * 24 * 30), // 30 days by default

    /*
    |--------------------------------------------------------------------------
    | Token Prefix
    |--------------------------------------------------------------------------
    |
    | Prefix for tokens to prevent accidental exposure in version control.
    |
    */
    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', 'sbs_'), // Custom prefix for your app

    /*
    |--------------------------------------------------------------------------
    | Sanctum Guards
    |--------------------------------------------------------------------------
    |
    | Authentication guards checked when authenticating requests.
    |
    */
    'guard' => ['web', 'api'],

    /*
    |--------------------------------------------------------------------------
    | Middleware Groups
    |--------------------------------------------------------------------------
    |
    | Middleware used for authenticating first-party SPAs.
    |
    */
    'middleware' => [
        'encrypt_cookies' => Illuminate\Cookie\Middleware\EncryptCookies::class,
        'validate_csrf_token' => Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Token Abilities
    |--------------------------------------------------------------------------
    |
    | Default abilities assigned to new tokens.
    |
    */
    'abilities' => [
        'customer' => [
            'service:view',
            'booking:create',
            'booking:view-own',
        ],
        'admin' => [
            'service:*',
            'booking:*',
            'user:view',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Token Name
    |--------------------------------------------------------------------------
    |
    | Default name for new tokens.
    |
    */
    'token_name' => env('SANCTUM_TOKEN_NAME', 'Service Booking System Token'),

];
