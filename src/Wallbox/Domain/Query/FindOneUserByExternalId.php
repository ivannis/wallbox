<?php

declare(strict_types=1);

namespace Wallbox\Domain\Query;

use Doblio\Core\Messaging\Query\Query;

class FindOneUserByExternalId implements Query
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }
}
