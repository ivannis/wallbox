<?php

declare(strict_types=1);

namespace Wallbox\UI\Http\Controller;

use Doblio\HyperfBridge\Http\Controller\Controller;

class InfoController extends Controller
{
    public function index()
    {
        return [
            'version' => 'Wallbox API version 1.0.0'
        ];
    }
}
