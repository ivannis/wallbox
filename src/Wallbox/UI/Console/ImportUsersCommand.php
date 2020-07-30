<?php

declare(strict_types=1);

namespace Wallbox\UI\Console;

use Common\Application\MessageBus;
use Doblio\Core\Messaging\Stamp\Command\AsyncStamp;
use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputOption;
use Wallbox\UI\Console\Command\BatchLoadFromCSV;

/**
 * @Command
 */
class ImportUsersCommand extends HyperfCommand
{
    protected ContainerInterface $container;
    protected MessageBus $bus;
    private string $source;
    private string $destination;

    public function __construct(MessageBus $bus, ConfigInterface $config)
    {
        $this->bus = $bus;
        $this->source = $config->get('csv_url');
        $this->destination = BASE_PATH .'/storage/csv/users.csv';

        parent::__construct('import:users');
    }

    public function handle()
    {
        $this->line('Loading users csv file ...', 'info');

        $limit = (int) $this->input->getOption('limit');
        $async = (bool) $this->input->getOption('async');
        $delay = (int) $this->input->getOption('delay');

        file_put_contents($this->destination, file_get_contents($this->source));

        $stamps = [];
        if ($async) {
            $stamps[] = new AsyncStamp($delay);
        }

        $this->bus->dispatch(
            new BatchLoadFromCSV(
                $this->destination,
                0,
                $limit,
                $async,
                $delay
            ),
            ...$stamps
        );
    }

    protected function getOptions()
    {
        return [
            ['limit', 'l', InputOption::VALUE_OPTIONAL, 'Number of users to load in each batch process', 25],
            ['async', 'a', InputOption::VALUE_OPTIONAL, 'The batch processing should be async?', true],
            ['delay', 'd', InputOption::VALUE_OPTIONAL, 'The delay between each batch processing', 0],
        ];
    }
}
