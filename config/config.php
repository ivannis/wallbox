<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Log\LogLevel;

return [
    'app_name' => env('APP_NAME', 'Wallbox'),
    'app_debug' => env('APP_DEBUG', true),
    'app_url' => env('APP_URL', 'http://localhost'),
    'jwt_key' => env('JWT_KEY', 'myVerySecretKey'),
    'csv_url' => env('CSV_URL', 'https://wallbox.s3-eu-west-1.amazonaws.com/img/test/users.csv'),
    'migration_paths' => [
        'default' => 'migrations'
    ],
    StdoutLoggerInterface::class => [
        'log_level' => [
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::DEBUG,
            LogLevel::EMERGENCY,
            LogLevel::ERROR,
            LogLevel::INFO,
            LogLevel::NOTICE,
            LogLevel::WARNING,
        ],
    ],
];
