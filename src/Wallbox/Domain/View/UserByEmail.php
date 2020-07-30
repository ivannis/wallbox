<?php

declare(strict_types=1);

namespace Wallbox\Domain\View;

use Doblio\Core\ValueObject\Web\EmailAddress;
use Doblio\Domain\View;
use Wallbox\Domain\UserId;

class UserByEmail implements View
{
    private UserId $id;
    private int $externalId;
    private EmailAddress $email;

    public function __construct(UserId $id, int $externalId, EmailAddress $email)
    {
        $this->id = $id;
        $this->email = $email;
        $this->externalId = $externalId;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function externalId(): int
    {
        return $this->externalId;
    }

    public function email(): EmailAddress
    {
        return $this->email;
    }
}
