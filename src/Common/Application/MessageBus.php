<?php

declare(strict_types=1);

namespace Common\Application;

use Doblio\Core\Messaging\Command\Command;
use Doblio\Core\Messaging\Query\Query;
use Doblio\Core\Messaging\Stamp\Query\ResponseStamp;
use Doblio\Core\Messaging\Stamp\Stamp;
use Doblio\Core\Messaging\MessageBus as Bus;

class MessageBus
{
    private Bus $bus;

    public function __construct(Bus $bus)
    {
        $this->bus = $bus;
    }

    public function dispatch(Command $command, Stamp ...$stamps)
    {
        $this->bus->dispatch($command, ...$stamps);
    }

    public function execute(Query $query, Stamp ...$stamps)
    {
        return $this->bus
            ->dispatch($query, ...$stamps)
            ->last(ResponseStamp::class)
            ->result()
        ;
    }
}
