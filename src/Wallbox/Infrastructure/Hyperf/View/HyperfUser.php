<?php

declare(strict_types=1);

namespace Wallbox\Infrastructure\Hyperf\View;

use Doblio\HyperfBridge\Annotation\Model;
use Wallbox\Infrastructure\Hyperf\Model\HyperfModel;

/**
 * @Model(entityClass="Wallbox\Domain\View\User")
 */
class HyperfUser extends HyperfModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this
            ->setTable('user_view')
        ;
    }
}
