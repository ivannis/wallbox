<?php

declare(strict_types=1);

namespace WallboxTest\Functional\Context;

use Doblio\HyperfBridge\Testing\Behat\Context\ContainerAwareContext;
use Psr\Container\ContainerInterface;

class FeatureContext implements ContainerAwareContext
{
    private ContainerInterface $container;
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
