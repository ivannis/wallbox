<?php

declare(strict_types=1);

namespace Wallbox\Domain;

use Doblio\Core\ValueObject\Identity\Uuid;

/**
 * @method static static fromNative(string $value)
 */
class UserId extends Uuid
{
}
