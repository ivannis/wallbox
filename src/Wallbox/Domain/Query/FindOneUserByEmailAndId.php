<?php

declare(strict_types=1);

namespace Wallbox\Domain\Query;

use Doblio\Core\Messaging\Query\Query;
use Doblio\Core\ValueObject\PhoneNumber\MobileNumber;
use Doblio\Core\ValueObject\Web\EmailAddress;

class FindOneUserByEmailAndId implements Query
{
    private int $id;
    private EmailAddress $email;

    public function __construct(int $id, EmailAddress $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function email(): EmailAddress
    {
        return $this->email;
    }
}
