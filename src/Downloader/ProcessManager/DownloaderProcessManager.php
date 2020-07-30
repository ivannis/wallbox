<?php

declare(strict_types=1);

namespace Downloader\ProcessManager;

use Common\Application\MessageBus;
use Doblio\Core\Messaging\Annotation\EventHandler;
use Doblio\Core\Messaging\Stamp\Command\AsyncStamp;
use Downloader\Command\LoadBatchFromCSV;
use Downloader\Event\CSVFileCreated;

class DownloaderProcessManager
{
    private MessageBus $bus;

    public function __construct(MessageBus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @EventHandler
     */
    public function whenCSVFileCreated(CSVFileCreated $event)
    {
        $stamps = [];
        if ($event->async()) {
            $stamps[] = new AsyncStamp($event->delay());
        }

        $this->bus->dispatch(
            new LoadBatchFromCSV(
                $event->destination(),
                0,
                $event->limit(),
                $event->async(),
                $event->delay(),
            ),
            ...$stamps
        );
    }
}
