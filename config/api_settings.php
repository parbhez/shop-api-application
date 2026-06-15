<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Static Token Authentication
    |--------------------------------------------------------------------------
    |
    | Determine if the API requires the static token for access.
    |
    */
    'enabled' => env('API_TOKEN_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | API Static Token
    |--------------------------------------------------------------------------
    |
    | The token required in the Authorization Bearer header.
    |
    */
    'static_token' => env('API_STATIC_TOKEN', 'v8Kp9xLQ2mZ7rT6sN1cD4fGh8JkP3aWq'),
];
