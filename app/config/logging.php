<?php

return [
    'rollbar' => [
        'enabled' => (bool) env('ROLLBAR_ENABLED', false),
        'access_token' => env('ROLLBAR_ACCESS_TOKEN'),
        'environment' => env('APP_ENV', 'local'),
    ]
];
