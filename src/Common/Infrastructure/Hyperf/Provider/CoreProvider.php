<?php

declare(strict_types=1);

namespace Common\Infrastructure\Hyperf\Provider;

use Doblio\Core\Messaging\Middleware\RouteMessageMiddleware;
use Doblio\Core\Messaging\SimpleMessageBus;
use Doblio\HyperfBridge\Config\Provider\ServiceProvider;
use Common\Application\MessageBus;
use Psr\Container\ContainerInterface;

class CoreProvider extends ServiceProvider
{
    public function register()
    {
        // message bus
        $this->app->bind(MessageBus::class, function (ContainerInterface $container) {
            return new MessageBus(
                new SimpleMessageBus($container->get(RouteMessageMiddleware::class))
            );
        });
    }
}
