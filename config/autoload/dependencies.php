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

use Doblio\HyperfBridge\Logger\Logger;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;

return [
    StdoutLoggerInterface::class => value(function () {
        $appEnv = env('APP_ENV', 'prod');

        if ($appEnv == 'prod') {
            return function(ContainerInterface $container) {
                /** @var LoggerFactory $factory */
                $factory = $container->get(LoggerFactory::class);

                return $factory->get('log', 'default');
            };
        }

        return Logger::class;
    }),
];
