<?php

declare(strict_types=1);

namespace Wallbox\UI\Console\Command;

use Doblio\Core\Messaging\Command\Command;

class BatchLoadFromCSV implements Command
{
    private string $file;
    private int $offset;
    private int $limit;

    public function __construct(string $file, int $offset, int $limit)
    {
        $this->file = $file;
        $this->offset = $offset;
        $this->limit = $limit;
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
}
