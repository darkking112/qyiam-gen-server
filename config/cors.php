<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Removed the specific localhost API path as it's redundant

    'allowed_methods' => ['*'], // Allow all HTTP methods (GET, POST, PUT, DELETE, etc.)

    'allowed_origins' => ['https://qyiam-gen.netlify.app'], // Removed '*' to avoid conflicts

    'allowed_origins_patterns' => [], // No need for patterns if you list origins explicitly

    'allowed_headers' => ['*'], // Allow all headers

    'exposed_headers' => [], // No headers need to be exposed here

    'max_age' => 0, // Preflight request cache time (0 means no caching)

    'supports_credentials' => false, // Use `true` only if you're sending cookies or HTTP authentication
];
