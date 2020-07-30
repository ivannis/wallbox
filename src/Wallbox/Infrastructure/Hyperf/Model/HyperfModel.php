<?php

declare(strict_types=1);

namespace Wallbox\Infrastructure\Hyperf\Model;

use Doblio\HyperfBridge\Database\Model;

abstract class HyperfModel extends Model
{
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'createdAt';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updatedAt';
}
