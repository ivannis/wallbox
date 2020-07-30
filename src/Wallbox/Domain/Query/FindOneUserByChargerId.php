<?php

declare(strict_types=1);

namespace Wallbox\Domain\Query;

use Doblio\Core\Messaging\Query\Query;

class FindOneUserByChargerId implements Query
{
    private int $id;
    private int $chargerId;

    public function __construct(int $id, int $chargerId)
    {
        $this->id = $id;
        $this->chargerId = $chargerId;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function chargerId(): int
    {
        return $this->chargerId;
    }
}
