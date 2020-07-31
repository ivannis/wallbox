<?php

declare(strict_types=1);

namespace WallboxTest\Functional\Context;

use Behat\Gherkin\Node\TableNode;
use Doblio\HyperfBridge\Testing\Behat\Context\ContainerAwareContext;
use Psr\Container\ContainerInterface;
use Wallbox\Application\UserService;
use Wallbox\Domain\UserId;

class UserContext implements ContainerAwareContext
{
    private ContainerInterface $container;

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @Given /^the following user(?:|s) exists:$/
     */
    public function theFollowingUsersExists(TableNode $table)
    {
        $service = $this->userService();
        foreach ($table->getHash() as $row) {
            $service->create(
                UserId::next()->toNative(),
                (int) $row['id'],
                $row['name'],
                $row['surname'],
                $row['email'],
                $row['country'],
                (int) $row['chargerId'],
                $row['createdAt'],
                $row['activatedAt']
            );
        }
    }

    private function userService(): UserService
    {
        return $this->container->get(UserService::class);
    }
}
