<?php

declare(strict_types=1);

namespace Wallbox\UI\Http\Controller;

use Wallbox\Application\UserService;
use Wallbox\UI\Http\Normalizer\UserNormalizer;
use Wallbox\UI\Http\Request\UsersRequest;
use Hyperf\HttpServer\Contract\ResponseInterface;

class UserController
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(UsersRequest $request, ResponseInterface $response)
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
}
