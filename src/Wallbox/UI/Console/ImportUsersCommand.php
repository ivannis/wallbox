<?php

declare(strict_types=1);

namespace Wallbox\UI\Console;

use Common\Application\MessageBus;
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
        file_put_contents($this->destination, file_get_contents($this->source));

        $this->bus->dispatch(new BatchLoadFromCSV(
            $this->destination,
            0,
            $limit
        ));
    }

    protected function getOptions()
    {
        return [
            ['limit', 'l', InputOption::VALUE_OPTIONAL, 'Number of users to load in each batch process', 25]
        ];
    }
}
