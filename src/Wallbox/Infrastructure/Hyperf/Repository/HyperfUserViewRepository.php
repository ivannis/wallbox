<?php

declare(strict_types=1);

namespace Wallbox\Infrastructure\Hyperf\Repository;

use Doblio\Core\Messaging\MessageBus;
use Doblio\Core\Serializer\Serializer;
use Doblio\HyperfBridge\Database\Repository\HyperfViewRepository;
use Hyperf\Utils\Collection;
use Wallbox\Domain\View\UserViewRepository;
use Wallbox\Infrastructure\Hyperf\View\HyperfUser;

class HyperfUserViewRepository extends HyperfViewRepository implements UserViewRepository
{
    public function __construct(Serializer $serializer, MessageBus $bus)
    {
        parent::__construct(new HyperfUser(), $serializer, $bus);
    }

    public function filterUsers(array $countries = [], ?int $​activationLength, array $orderBy = []): Collection
    {
        $query = $this->query();
        if (!empty($countries)) {
            $query = $query->whereIn('country', $countries);
        }

        if ($​activationLength) {
            $query = $query->whereRaw('DATEDIFF(activatedAt, createdAt) >= ?', [$​activationLength]);
        }

        return $this->addOrderBy($query, $orderBy)->get();
    }
}
