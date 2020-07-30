<?php

declare(strict_types=1);

use Doblio\HyperfBridge\Testing\Autoload\Autoloader;
use Hyperf\Utils\ApplicationContext;
use LiveCodeCoverage\LiveCodeCoverage;

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');

error_reporting(E_ALL ^ E_DEPRECATED);
putenv("APP_ENV=test");

! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 2));
! defined('SWOOLE_HOOK_FLAGS') && define('SWOOLE_HOOK_FLAGS', SWOOLE_HOOK_ALL);

require BASE_PATH . '/vendor/autoload.php';

(function () {
    $container = Autoloader::getContainer(require __DIR__. '/../autoload.php');
    ApplicationContext::setContainer($container);

    Autoloader::getApplication($container)->run('start');
})();