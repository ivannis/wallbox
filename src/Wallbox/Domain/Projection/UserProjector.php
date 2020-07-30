<?php

declare(strict_types=1);

namespace Wallbox\Domain\Projection;

use Doblio\Core\Messaging\Annotation\EventHandler;
use Doblio\Core\Messaging\Annotation\QueryHandler;
use Hyperf\Utils\Collection;
use Wallbox\Domain\Event\UserCreated;
use Wallbox\Domain\Query\FindAllUserByCriteria;
use Wallbox\Domain\Query\FindOneUserByExternalId;
use Wallbox\Domain\View\User;
use Wallbox\Domain\View\UserViewRepository;

class UserProjector
{
    private UserViewRepository $repository;

    public function __construct(UserViewRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @EventHandler(async=true)
     */
    public function whenUserCreated(UserCreated $event)
    {
        $user = new User(
            $event->id(),
            $event->externalId(),
            $event->name(),
            $event->surname(),
            $event->email(),
            $event->country(),
            $event->chargerId(),
            $event->createdAt(),
            $event->createdAt(),
            $event->activatedAt()
        );

        $this->repository->create($user);
    }

    /**
     * @QueryHandler
     */
    public function findOneUserByExternalId(FindOneUserByExternalId $query): ?User
    {
        return $this->repository->findOneBy([
            'externalId' => $query->id()
        ]);
    }

    /**
     * @QueryHandler
     */
    public function findAllUserByCriteria(FindAllUserByCriteria $query): Collection
    {
        return $this->repository->filterUsers(
            $query->countries(),
            $query->activationLength(),
            ['name' => 'asc', 'surname' => 'asc']
        );
    }
}
