<?php

declare(strict_types=1);

namespace Downloader\Command;

use Doblio\Core\Messaging\Command\Command;

class LoadBatchFromCSV implements Command
{
    private string $file;
    private int $offset;
    private int $limit;
    private bool $async;
    private int $delay;

    public function __construct(string $file, int $offset, int $limit, bool $async = true, int $delay = 0)
    {
        $this->file = $file;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->async = $async;
        $this->delay = $delay;
    }

    public function file(): string
    {
        return $this->file;
    }

    public function offset(): int
    {
        return $this->offset;
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
