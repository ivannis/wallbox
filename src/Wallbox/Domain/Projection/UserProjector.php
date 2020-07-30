<?php

declare(strict_types=1);

namespace Wallbox\Domain\Projection;

use Doblio\Core\Messaging\Annotation\EventHandler;
use Doblio\Core\Messaging\Annotation\QueryHandler;
use Doblio\Core\ValueObject\DateTime\DateTime;
use Hyperf\Utils\Collection;
use Wallbox\Domain\Event\UserCreated;
use Wallbox\Domain\Event\UserUpdated;
use Wallbox\Domain\Query\FindAllUserByCriteria;
use Wallbox\Domain\Query\FindOneUserByChargerId;
use Wallbox\Domain\Query\FindOneUserByExternalId;
use Wallbox\Domain\UserId;
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
     * @EventHandler(async=true)
     */
    public function whenUserUpdated(UserUpdated $event)
    {
        $user = $this->findOneById($event->id());

        $user->setName($event->name());
        $user->setSurname($event->surname());
        $user->setEmail($event->email());
        $user->setCountry($event->country());
        $user->setChargerId($event->chargerId());
        $user->setUpdatedAt(DateTime::now());

        $this->repository->save($user);
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
    public function findOneUserByChargerId(FindOneUserByChargerId $query): ?User
    {
        return $this->repository->findOneBy([
            ['externalId', '!=', $query->id()],
            'chargerId' => $query->chargerId()
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

    private function findOneById(UserId $userId): User
    {
        return $this->repository->findOneOrFail($userId);
    }
}
