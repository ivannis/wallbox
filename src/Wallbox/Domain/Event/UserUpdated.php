<?php

declare(strict_types=1);

namespace Wallbox\Domain\Event;

use Doblio\Core\ValueObject\Geography\CountryCode;
use Doblio\Core\ValueObject\Web\EmailAddress;
use Doblio\Domain\Event\DomainEvent;
use Wallbox\Domain\UserId;

class UserUpdated implements DomainEvent
{
    private UserId $id;
    private string $name;
    private string $surname;
    private EmailAddress $email;
    private CountryCode $country;
    private int $chargerId;

    public function __construct(
        UserId $id,
        string $name,
        string $surname,
        EmailAddress $email,
        CountryCode $country,
        int $chargerId
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->country = $country;
        $this->chargerId = $chargerId;
    }

    public function id(): UserId
    {
        return $this->id;
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
}
