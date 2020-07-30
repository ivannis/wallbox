<?php

declare(strict_types=1);

namespace Wallbox\Domain\View;

use Doblio\Domain\Repository\ViewRepository;

interface UserViewRepository extends ViewRepository
{
    public function filterUsers(array $countries = [], ?int $​activationLength, array $orderBy = []): iterable;
}