<?php

declare(strict_types=1);

namespace Wallbox\Domain\Exception;

use Doblio\Domain\Exception\LogicException;

class UserAlreadyExists extends LogicException
{
    public function __construct(string $message = 'User already exists', Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }
}
