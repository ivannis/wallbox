<?php

declare(strict_types=1);

namespace WallboxTest\Functional\Context;

use Doblio\Core\ValueObject\DateTime\DateTime;
use Doblio\HyperfBridge\Testing\Behat\Context\ContainerAwareContext;
use Hyperf\AsyncQueue\Environment;
use Psr\Container\ContainerInterface;

class FeatureContext implements ContainerAwareContext
{
    private ContainerInterface $container;
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @BeforeScenario
     */
    public function disableAsyncJobs()
    {
        /** @var Environment $environment */
        $environment = $this->container->get(Environment::class);
        $environment->setAsyncQueue(true);
    }

    /**
     * @AfterScenario
     */
    public function enableAsyncJobs()
    {
        /** @var Environment $environment */
        $environment = $this->container->get(Environment::class);
        $environment->setAsyncQueue(false);
    }

    /**
     * @Given the current date-time is :dateTime
     */
    public function freezeTimeWithDateTime($dateTime)
    {
        DateTime::setTestNow(DateTime::fromStringUTC($dateTime));
    }
}
