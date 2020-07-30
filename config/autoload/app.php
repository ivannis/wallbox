<?php

declare(strict_types=1);

use Common\Infrastructure\Hyperf\Provider as Common;
use Doblio\Core\Messaging\Event\ForwardTo\Amqp\AmqpEventForwarder;
use Doblio\Core\Messaging\Event\ForwardTo\Mercure\MercureEventForwarder;
use Doblio\Core\Messaging\Event\ForwardTo\Sync\SyncEventForwarder;
use Doblio\Core\Messaging\Middleware\CommandHandlerMiddleware;
use Doblio\Core\Messaging\Middleware\EventHandlerMiddleware;
use Doblio\Core\Messaging\Middleware\ForwardEventMiddleware;
use Doblio\Core\Messaging\Middleware\MetadataToStampMiddleware;
use Doblio\Core\Messaging\Middleware\QueryHandlerMiddleware;
use Doblio\Core\Serializer\Handler\CollectionHandler;
use Doblio\Core\Serializer\Handler\HashMapHandler;
use Doblio\Domain\Middleware\HandlesRecordedEventsMiddleware;
use Doblio\HyperfBridge\Config\Context;
use Doblio\HyperfBridge\Config\Kernel;
use Doblio\HyperfBridge\EventProcessor\Creator\AmqpProcessCreator;
use Doblio\HyperfBridge\Messaging\Middleware\AsyncCommandMiddleware;
use Doblio\HyperfBridge\Messaging\Middleware\TransactionalCommandMiddleware;
use Wallbox\Infrastructure\Hyperf\Provider as Wallbox;

/*
|--------------------------------------------------------------------------
| Create the application kernel
|--------------------------------------------------------------------------
*/

$kernel = new Kernel(env('APP_ENV', 'prod'), env('APP_DEBUG', false));

/*
|--------------------------------------------------------------------------
| Create the application contexts
|--------------------------------------------------------------------------
*/

$common = new Context();
$wallbox = new Context();

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$common->register(Common\CoreProvider::class);
$wallbox->register(Wallbox\CoreProvider::class);

/*
|--------------------------------------------------------------------------
| Register application contexts
|--------------------------------------------------------------------------
*/

$kernel->register($common);
$kernel->register($wallbox);

return [
    'dependencies' => $kernel->definitions(),
    'command_bus' => [
        'middlewares' => [
            MetadataToStampMiddleware::class,
            HandlesRecordedEventsMiddleware::class,
            AsyncCommandMiddleware::class,
            TransactionalCommandMiddleware::class,
            CommandHandlerMiddleware::class,
        ],
    ],
    'event_bus' => [
        'middlewares' => [
            MetadataToStampMiddleware::class,
            EventHandlerMiddleware::class,
            ForwardEventMiddleware::class,
        ],
    ],
    'query_bus' => [
        'middlewares' => [
            QueryHandlerMiddleware::class,
        ]
    ],
    'serializer' => [
        'cache_dir' => BASE_PATH . '/runtime/doblio/serializer',
        'definitions' => BASE_PATH . '/config/serializer',
        'handlers' => [
            CollectionHandler::class,
            HashMapHandler::class,
        ],
    ],
    'event_forwarder' => [
        'transports' => [
            'amqp' => AmqpEventForwarder::class,
            'mercure' => MercureEventForwarder::class,
            'sync' => SyncEventForwarder::class,
        ]
    ],
    'event_processor' => [
        'transports' => [
            'amqp' => AmqpProcessCreator::class
        ]
    ]
];