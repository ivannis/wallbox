<?php

declare(strict_types=1);

namespace Wallbox\Infrastructure\Hyperf\Model;

use Doblio\HyperfBridge\Annotation\Model;

/**
 * @Model(entityClass="Wallbox\Domain\User")
 */
class HyperfUser extends HyperfModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this
            ->setTable('user')
        ;
    }
}
