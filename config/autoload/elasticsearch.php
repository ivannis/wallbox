<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

$options = [
    'servers' => [
        [
            'host' => env('ES_HOST', '127.0.0.1'),
            'port' => env('ES_PORT', 9200),
            'user' => env('ES_USER', ''),
            'pass' => env('ES_PASS', ''),
            'scheme' => env('ES_SCHEME', 'http'),
        ]
    ],
    'retries' => 3,
    'pool' => [
        'min_connections' => 1,
        'max_connections' => 10,
        'wait_timeout' => 10.0,
        'max_idle_time' => (float) env('ES_MAX_IDLE_TIME', 60),
    ],
];

return [
    /*
    |--------------------------------------------------------------------------
    | Default Elasticsearch Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the Elasticsearch connections below you wish
    | to use as your default connection for all work. Of course.
    |
    */

    'default' => env('ES_CONNECTION', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Elasticsearch Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the Elasticsearch connections setup for your application.
    | Of course, examples of configuring each Elasticsearch platform.
    |
    */

    'connections' => [
        'default' => array_merge($options, [
            'indices' => ['wallbox_user'],
        ]),
    ],

    /*
    |--------------------------------------------------------------------------
    | Elasticsearch Indices
    |--------------------------------------------------------------------------
    |
    | Here you can define your indices, with separate settings and mappings.
    | Edit settings and mappings and run 'php artisan es:index:update' to update
    | indices on elasticsearch server.
    |
    | 'my_index' is just for test. Replace it with a real index name.
    |
    */

    'indices' => [
        'wallbox_user' => [
            'settings' => [
                'number_of_shards' => 1,
                'number_of_replicas' => 0,
                'index.mapping.ignore_malformed' => false,
                "analysis" => [
                    "filter" => [],
                    "analyzer" => []
                ]
            ],
            'mappings' => [
                'properties' => [
                    'name' => [
                        'type' => 'keyword'
                    ],
                    'surname' => [
                        'type' => 'keyword'
                    ],
                    'country' => [
                        'type' => 'keyword'
                    ],
                ]
            ]
        ],
    ]
];
