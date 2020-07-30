<?php

declare(strict_types=1);

namespace Downloader\Event;

use Doblio\Core\Messaging\Event\Event;

class CSVFileCreated implements Event
{
    private string $destination;
    private int $limit;
    private bool $async;
    private int $delay;

    public function __construct(string $destination, int $limit, bool $async = true, int $delay = 0)
    {
        $this->destination = $destination;
        $this->limit = $limit;
        $this->async = $async;
        $this->delay = $delay;
    }

    public function destination(): string
    {
        return $this->destination;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function async(): bool
    {
        return $this->async;
    }

    public function delay(): int
    {
        return $this->delay;
    }
}
