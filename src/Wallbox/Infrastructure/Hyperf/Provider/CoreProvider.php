<?php

declare(strict_types=1);

namespace Wallbox\Infrastructure\Hyperf\Provider;

use Doblio\HyperfBridge\Config\Provider\ServiceProvider;
use Wallbox\Domain\View\UserViewRepository;
use Wallbox\Infrastructure\Hyperf\Repository\HyperfUserViewRepository;

class CoreProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->alias(UserViewRepository::class, HyperfUserViewRepository::class);
    }
}
