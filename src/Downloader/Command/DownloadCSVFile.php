<?php

declare(strict_types=1);

namespace Downloader\Command;

use Doblio\Core\Messaging\Command\Command;

class DownloadCSVFile implements Command
{
    private string $url;
    private int $limit;
    private bool $async;
    private int $delay;

    public function __construct(string $url, int $limit, bool $async = true, int $delay = 0)
    {
        $this->url = $url;
        $this->limit = $limit;
        $this->async = $async;
        $this->delay = $delay;
    }

    public function url(): string
    {
        return $this->url;
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
