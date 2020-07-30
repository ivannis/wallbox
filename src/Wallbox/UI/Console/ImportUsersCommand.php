<?php

declare(strict_types=1);

namespace Wallbox\UI\Console;

use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Contract\ConfigInterface;
use Symfony\Component\Console\Input\InputOption;
use Downloader\DownloaderService;

/**
 * @Command
 */
class ImportUsersCommand extends HyperfCommand
{
    private DownloaderService $service;
    private string $source;

    public function __construct(DownloaderService $service, ConfigInterface $config)
    {
        $this->service = $service;
        $this->source = $config->get('csv_url');

        parent::__construct('import:users');
    }

    public function handle()
    {
        $this->line('Loading users from csv file ...', 'info');

        $limit = (int) $this->input->getOption('limit');
        $async = (bool) $this->input->getOption('async');
        $delay = (int) $this->input->getOption('delay');

        $this->service->download(
            $this->source,
            $limit,
            $async,
            $delay
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
