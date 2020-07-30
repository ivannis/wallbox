<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;
use Wallbox\UI\Http\Controller\InfoController;
use Wallbox\UI\Http\Controller\UserController;

Router::get('/', [InfoController::class, 'index']);

Router::addGroup('/v1',function () {

    Router::addGroup('/users',function () {
        Router::get('/', [UserController::class, 'index']);
        Router::post('/import', [UserController::class, 'import']);
    });
});
