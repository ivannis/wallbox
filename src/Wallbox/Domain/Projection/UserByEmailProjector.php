<?php

declare(strict_types=1);

namespace Wallbox\Domain\Projection;

use Doblio\Core\Messaging\Annotation\EventHandler;
use Doblio\Core\Messaging\Annotation\QueryHandler;
use Doblio\Domain\Repository\RepositoryManager;
use Doblio\Domain\Repository\ViewRepository;
use Wallbox\Domain\Event\UserCreated;
use Wallbox\Domain\Event\UserUpdated;
use Wallbox\Domain\Query\FindOneUserByEmailAndId;
use Wallbox\Domain\UserId;
use Wallbox\Domain\View\UserByEmail;

class UserByEmailProjector
{
    private ViewRepository $repository;

    public function __construct(RepositoryManager $repositoryManager)
    {
        $this->repository = $repositoryManager->getViewRepository(UserByEmail::class);
    }

    /**
     * @EventHandler(async=true)
     */
    public function whenUserCreated(UserCreated $event)
    {
        $userByPhone = new UserByEmail(
            $event->id(),
            $event->externalId(),
            $event->email()
        );

        $this->repository->create($userByPhone);
    }

    /**
     * @EventHandler(async=true)
     */
    public function whenUserUpdated(UserUpdated $event)
    {
        $userByPhone = $this->findOneById($event->id());
        $userByPhone->setEmail($event->email());

        $this->repository->save($userByPhone);
    }

    /**
     * @QueryHandler
     */
    public function findOneByEmailAndId(FindOneUserByEmailAndId $query): ?UserByEmail
    {
        return $this->repository->findOneBy([
            ['externalId', '!=', $query->id()],
            ['email', '=', $query->email()->toNative()]
        ]);
    }

    private function findOneById(UserId $userId): UserByEmail
    {
        return $this->repository->findOneOrFail($userId);
    }
}
