<?php

declare(strict_types=1);

namespace Downloader;

use Doblio\Core\Messaging\Annotation\CommandHandler;
use Doblio\Core\Messaging\MessageBus;
use Doblio\Core\Messaging\Stamp\Command\AsyncStamp;
use Doblio\Domain\Exception\Exception;
use Downloader\Command\DownloadCSVFile;
use Downloader\Command\LoadBatchFromCSV;
use Downloader\Event\CSVFileCreated;
use Downloader\Validator\RowValidator;
use League\Csv\Reader;
use League\Csv\Statement;
use Psr\Log\LoggerInterface;
use Wallbox\Application\UserService;
use Wallbox\Domain\UserId;

class DownloaderCommandHandler
{
    private MessageBus $bus;
    private UserService $service;
    private RowValidator $validator;
    private LoggerInterface $logger;
    private string $destination;
    private array $loggerContext = [
        'component' => 'batch-processing'
    ];

    public function __construct(
        MessageBus $bus,
        UserService $service,
        RowValidator $validator,
        LoggerInterface $logger
    ) {
        $this->bus = $bus;
        $this->service = $service;
        $this->validator = $validator;
        $this->logger = $logger;
        $this->destination = BASE_PATH .'/storage/csv/users.csv';
    }

    /**
     * @CommandHandler
     */
    public function downloadCSVFile(DownloadCSVFile $command)
    {
        file_put_contents($this->destination, file_get_contents($command->url()));

        $this->bus->dispatch(new CSVFileCreated(
            $this->destination,
            $command->limit(),
            $command->async(),
            $command->delay()
        ));
    }

    /**
     * @CommandHandler
     */
    public function loadBatchFromCSV(LoadBatchFromCSV $command)
    {
        $this->logger->info(
            'Loading users from {from} to {to} ...',
            array_merge([
                'from' => $command->offset(),
                'to' => ($command->offset() + $command->limit() - 1)
            ], $this->loggerContext)
        );

        if (!file_exists($command->file())) {
            $this->logger->error(
                "CSV file {fileName} doesn't exists.",
                array_merge([
                    'fileName' => $command->file(),
                ], $this->loggerContext)
            );

            return;
        }

        $csv = Reader::createFromPath($command->file(), 'r');
        $header = ['id', 'name', 'surname', 'email', 'country', 'createAt', 'activateAt', 'chargerId'];

        $stmt = (new Statement())
            ->offset($command->offset())
            ->limit($command->limit())
        ;

        $records = $stmt->process($csv, $header);
        if (count($records) === $command->limit()) {
            // load next batch
            $stamps = [];
            if ($command->async()) {
                $stamps[] = new AsyncStamp($command->delay());
            }

            $this->bus->dispatch(
                new LoadBatchFromCSV(
                    $command->file(),
                    $command->offset() + $command->limit(),
                    $command->limit(),
                    $command->async(),
                    $command->delay()
                ),
                ...$stamps
            );
        }

        foreach ($records as $record) {
            if ($this->validator->isValid($record)) {
                try {
                    if ($user = $this->service->findOneUserById((int) $record['id'])) {
                        $this->service->update(
                            $user->id()->toNative(),
                            (int) $record['id'],
                            $record['name'],
                            $record['surname'],
                            $record['email'],
                            $record['country'],
                            (int) $record['chargerId'],
                        );
                    } else {
                        $this->service->create(
                            UserId::next()->toNative(),
                            (int) $record['id'],
                            $record['name'],
                            $record['surname'],
                            $record['email'],
                            $record['country'],
                            (int) $record['chargerId'],
                            $record['createAt'],
                            $record['activateAt'],
                        );
                    }
                } catch (Exception $e) {
                    $context = array_merge([
                        'code' => $e->getCode(),
                        'message' => $e->getMessage()
                    ], $this->loggerContext);

                    $this->logger->error('Error {code}. {message}', $context);
                }
            } else {
                $context = array_merge([
                    'id' => $record['id'],
                    'errors' => json_encode($this->validator->errors(), JSON_PRETTY_PRINT)
                ], $this->loggerContext);

                $this->logger->error('Invalid arguments on user "{id}" {errors}', $context);
            }
        }
    }
}
