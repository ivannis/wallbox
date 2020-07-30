<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

$appEnv = env('APP_ENV', 'prod');
switch ($appEnv) {
    case 'test':
        $driver = \Doblio\HyperfBridge\Testing\Fake\AsyncQueue\InMemoryDriver::class;
        break;
    default:
        $driver = \Hyperf\AsyncQueue\Driver\RedisDriver::class;
        break;
}

return [
    'default' => [
        'driver' => $driver,
        'channel' => env('APP_NAME', 'Wallbox'),
        'timeout' => 2,
        'retry_seconds' => 5,
        'handle_timeout' => 10,
        'processes' => 1,
        'concurrent' => [
            'limit' => 10,
        ],
    ],
    'async-command' => [
        'driver' => $driver,
        'channel' => env('APP_NAME', 'Wallbox'),
        'timeout' => 2,
        'retry_seconds' => 5,
        'handle_timeout' => 10,
        'processes' => 1,
        'concurrent' => [
            'limit' => 10,
        ],
    ],
    'async-event' => [
        'driver' => $driver,
        'channel' => env('APP_NAME', 'Wallbox'),
        'timeout' => 2,
        'retry_seconds' => 5,
        'handle_timeout' => 10,
        'processes' => 1,
        'concurrent' => [
            'limit' => 10,
        ],
    ],
];
