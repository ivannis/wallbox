<?php

declare(strict_types=1);

namespace Wallbox\Domain\Query;

use Doblio\Core\Messaging\Query\Query;

class FindAllUserByCriteria implements Query
{
    private ?int $activationLength;
    private array $countries;

    public function __construct(?int $activationLength, array $countries = [])
    {
        $this->activationLength = $activationLength;
        $this->countries = $countries;
    }

    public function activationLength(): ?int
    {
        return $this->activationLength;
    }

    public function countries(): array
    {
        return $this->countries;
    }
}
