<?php

declare(strict_types=1);

return [
    'hub_url' => env('MERCURE_PUBLISH_URL', 'http://localhost/.well-known/mercure'),
    'jwt_key' => env('MERCURE_JWT_KEY', 'myVerySecretKey'),
];
