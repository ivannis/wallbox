<?php

declare(strict_types=1);

namespace Downloader;

use Common\Application\MessageBus;
use Downloader\Command\DownloadCSVFile;

class DownloaderService
{
    private MessageBus $bus;

    public function __construct(MessageBus $bus)
    {
        $this->bus = $bus;
    }

    public function download(string $url, int $limit, bool $async = true, int $delay = 0)
    {
        $this->bus->dispatch(
            new DownloadCSVFile(
                $url,
                $limit,
                $async,
                $delay
            )
        );
    }
}
