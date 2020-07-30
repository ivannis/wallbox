<?php

declare(strict_types=1);

namespace Wallbox\Domain\View;

use Doblio\Core\ValueObject\DateTime\DateTime;
use Doblio\Core\ValueObject\Geography\CountryCode;
use Doblio\Core\ValueObject\Web\EmailAddress;
use Doblio\Domain\View;
use Wallbox\Domain\UserId;

class User implements View
{
    private UserId $id;
    private int $externalId;
    private string $name;
    private string $surname;
    private EmailAddress $email;
    private CountryCode $country;
    private int $chargerId;

    private DateTime $createdAt;
    private DateTime $updatedAt;
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
        DateTime $updatedAt,
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
        $this->updatedAt = $updatedAt;
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

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function activatedAt(): DateTime
    {
        return $this->activatedAt;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function setEmail(EmailAddress $email): void
    {
        $this->email = $email;
    }

    public function setCountry(CountryCode $country): void
    {
        $this->country = $country;
    }

    public function setChargerId(int $chargerId): void
    {
        $this->chargerId = $chargerId;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
