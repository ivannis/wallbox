<?php

declare(strict_types=1);

namespace Wallbox\Domain\Exception;

use Doblio\Domain\Exception\LogicException;

class ChargerAlreadyExists extends LogicException
{
    public function __construct(string $message = 'Charger already exists', \Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }
}
