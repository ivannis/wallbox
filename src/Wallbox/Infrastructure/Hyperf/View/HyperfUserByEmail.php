<?php

declare(strict_types=1);

namespace Wallbox\Infrastructure\Hyperf\View;

use Doblio\HyperfBridge\Annotation\Model;
use Wallbox\Infrastructure\Hyperf\Model\HyperfModel;

/**
 * @Model(entityClass="Wallbox\Domain\View\UserByEmail")
 */
class HyperfUserByEmail extends HyperfModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this
            ->setTimestamps(false)
            ->setTable('user_by_email_view')
        ;
    }
}
