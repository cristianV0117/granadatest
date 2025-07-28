<?php

return [
    'paths' => ['graphql', 'api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://granadatestfront-production.up.railway.app'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
