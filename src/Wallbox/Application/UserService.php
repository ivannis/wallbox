<?php

declare(strict_types=1);

namespace Wallbox\Application;

use Common\Application\MessageBus;
use Doblio\Core\ValueObject\DateTime\DateTime;
use Doblio\Core\ValueObject\Geography\CountryCode;
use Doblio\Core\ValueObject\Web\EmailAddress;
use Hyperf\Utils\Collection;
use Wallbox\Domain\Command\CreateUser;
use Wallbox\Domain\Exception\UserAlreadyExists;
use Wallbox\Domain\Query\FindAllUserByCriteria;
use Wallbox\Domain\Query\FindOneUserByEmailAndId;
use Wallbox\Domain\Query\FindOneUserByExternalId;
use Wallbox\Domain\UserId;

class UserService
{
    private MessageBus $bus;

    public function __construct(MessageBus $bus)
    {
        $this->bus = $bus;
    }

    public function create(
        string $userId,
        int $externalId,
        string $name,
        string $surname,
        string $email,
        string $country,
        int $chargerId,
        string $createdAt,
        string $activatedAt
    ): void {
        if ($this->userAlreadyExists($externalId)) {
            throw new UserAlreadyExists(sprintf('A user with id "%s" already exists.', $externalId));
        }

        if ($this->emailAlreadyExists($externalId, $email)) {
            throw new UserAlreadyExists(sprintf('A user with email "%s" already exists.', $email));
        }

        $this->bus->dispatch(
            new CreateUser(
                UserId::fromNative($userId),
                $externalId,
                $name,
                $surname,
                EmailAddress::fromNative($email),
                CountryCode::fromNative($country),
                $chargerId,
                DateTime::fromFormat('Y-m-d', $createdAt),
                DateTime::fromFormat('Y-m-d', $activatedAt)
            )
        );
    }

    public function findAllBy(?int $activationLength = null, array $countries = []): Collection
    {
        return $this->bus->execute(new FindAllUserByCriteria($activationLength, $countries));
    }

    public function userAlreadyExists(int $externalId): bool
    {
        return $this->bus->execute(new FindOneUserByExternalId($externalId)) !== null;
    }

    private function emailAlreadyExists(int $externalId, string $email): bool
    {
        return $this->bus->execute(new FindOneUserByEmailAndId($externalId, EmailAddress::fromNative($email))) !== null;
    }
}
