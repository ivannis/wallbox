<?php

declare(strict_types=1);

namespace Wallbox\UI\Http\Controller;

use Downloader\DownloaderService;
use Hyperf\Contract\ConfigInterface;
use Wallbox\Application\UserService;
use Wallbox\UI\Http\Normalizer\UserNormalizer;
use Wallbox\UI\Http\Request\ImportUsersRequest;
use Wallbox\UI\Http\Request\UserListRequest;
use Hyperf\HttpServer\Contract\ResponseInterface;

class UserController
{
    private UserService $service;
    private DownloaderService $downloader;
    private string $source;

    public function __construct(UserService $service, DownloaderService $downloader, ConfigInterface $config)
    {
        $this->service = $service;
        $this->downloader = $downloader;
        $this->source = $config->get('csv_url');
    }

    public function index(UserListRequest $request, ResponseInterface $response)
    {
        $activationLength = $request->input('activation_length', null) ?
            (int) $request->input('activation_length') :
            null
        ;

        $countries = $request->input('countries', null) ?
            explode(',', $request->input('countries')) :
            []
        ;

        return $response->json(UserNormalizer::collection(
            $this->service->findAllBy(
                $activationLength,
                $countries,
            )
        ));
    }

    public function import(ImportUsersRequest $request)
    {
        $this->downloader->download(
            $this->source,
            (int) $request->input('limit', 25),
            (bool) $request->input('async', true),
            (int) $request->input('delay', 0),
        );

        return 'Loading users from csv file ...';
    }
}
