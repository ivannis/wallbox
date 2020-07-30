<?php

declare(strict_types=1);

namespace Wallbox\UI\Console\BatchProcessing;

use Common\Application\MessageBus;
use Doblio\Core\Messaging\Annotation\CommandHandler;
use League\Csv\Reader;
use League\Csv\Statement;
use Psr\Log\LoggerInterface;
use Wallbox\Application\UserService;
use Wallbox\Domain\UserId;
use Wallbox\UI\Console\Command\BatchLoadFromCSV;
use Wallbox\UI\Console\Validator\UserValidator;

class UserLoader
{
    private MessageBus $bus;
    private UserService $service;
    private UserValidator $validator;
    private LoggerInterface $logger;
    private array $loggerContext = [
        'component' => 'batch-processing'
    ];

    public function __construct(
        MessageBus $bus,
        UserService $service,
        UserValidator $validator,
        LoggerInterface $logger
    ) {
        $this->bus = $bus;
        $this->service = $service;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * @CommandHandler
     */
    public function whenBatchLoadFromCSV(BatchLoadFromCSV $command)
    {
        $context = array_merge([
            'from' => $command->offset(),
            'to' => ($command->offset() + $command->limit() - 1)
        ], $this->loggerContext);

        $this->logger->info('Loading users from {from} to {to} ...', $context);
        $csv = Reader::createFromPath($command->file(), 'r');

        $header = ['id', 'name', 'surname', 'email', 'country', 'createAt', 'activateAt', 'chargerId'];
        $stmt = (new Statement())
            ->offset($command->offset())
            ->limit($command->limit())
        ;

        $records = $stmt->process($csv, $header);
        if (count($records) === $command->limit()) {
            // load next batch
            $this->bus->dispatch(new BatchLoadFromCSV(
                $command->file(),
                $command->offset() + $command->limit(),
                $command->limit()
            ));
        }

        foreach ($records as $record) {
            if ($this->validator->isValid($record)) {
                if ($this->service->userAlreadyExists((int) $record['id'])) {

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
