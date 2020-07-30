<?php

declare(strict_types=1);

namespace Wallbox\Domain\Command;

use Doblio\Core\ValueObject\DateTime\DateTime;
use Doblio\Core\ValueObject\Geography\CountryCode;
use Doblio\Core\ValueObject\Web\EmailAddress;
use Doblio\Domain\Command\DomainCommand;
use Wallbox\Domain\UserId;

class CreateUser implements DomainCommand
{
    private UserId $id;
    private int $externalId;
    private string $name;
    private string $surname;
    private EmailAddress $email;
    private CountryCode $country;
    private int $chargerId;
    private DateTime $createdAt;
    private DateTime $activatedAt;

    public function __construct(
        UserId $id,
        int $externalId,
        string $name,
        string $surname,
        EmailAddress $email,
        CountryCode $country,
        int $chargerId,
        DateTime $createdAt,
        DateTime $activatedAt
    ) {
        $this->id = $id;
        $this->externalId = $externalId;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->country = $country;
        $this->chargerId = $chargerId;

        $this->createdAt = $createdAt;
        $this->activatedAt = $activatedAt;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function externalId(): int
    {
        return $this->externalId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function surname(): string
    {
        return $this->surname;
    }

    public function email(): EmailAddress
    {
        return $this->email;
    }

    public function country(): CountryCode
    {
        return $this->country;
    }

    public function chargerId(): int
    {
        return $this->chargerId;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function activatedAt(): DateTime
    {
        return $this->activatedAt;
    }
}
