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

return [
    'generator' => [
        'domain' => [
            'command' => [
                'user' => [
                    'namespace' => 'Wallbox\\Domain\\Command',
                ],
                'handler' => [
                    'user' => [
                        'namespace' => 'Wallbox\\Domain\\Command',
                    ],
                ],
            ],
            'query' => [
                'user' => [
                    'namespace' => 'Wallbox\\Domain\\Query',
                ],
                'handler' => [
                    'user' => [
                        'namespace' => 'Wallbox\\Domain\\Query',
                    ],
                ],
            ],
            'event' => [
                'user' => [
                    'namespace' => 'Wallbox\\Domain\\Event',
                ],
            ],
            'aggregate' => [
                'user' => [
                    'namespace' => 'Wallbox\\Domain',
                ],
                'uuid' => [
                    'user' => [
                        'namespace' => 'Wallbox\\Domain',
                    ],
                ],
                'repository' => [
                    'user' => [
                        'namespace' => 'Wallbox\\Domain',
                    ],
                ],
            ],
            'entity' => [
                'user' => [
                    'namespace' => 'Wallbox\\Domain',
                ],
            ],
            'view' => [
                'user' => [
                    'namespace' => 'Wallbox\\Domain\\View',
                ],
                'repository' => [
                    'user' => [
                        'namespace' => 'Wallbox\\Domain\\View',
                    ],
                ]
            ],
            'projector' => [
                'user' => [
                    'namespace' => 'Wallbox\\Domain\\Projection',
                ],
            ],
            'process' => [
                'manager' => [
                    'user' => [
                        'namespace' => 'Wallbox\\Domain\\ProcessManager',
                    ],
                ],
            ],
        ],
        'application' => [
            'service' => [
                'user' => [
                    'namespace' => 'Wallbox\\Application',
                ],
            ],
        ],
        'infrastructure' => [
            'model' => [
                'user' => [
                    'namespace' => 'Wallbox\\Infrastructure\\Hyperf\\Model',
                ],
            ],
            'provider' => [
                'user' => [
                    'namespace' => 'Wallbox\\Infrastructure\\Hyperf\\Provider',
                ],
                'base' => [
                    'user' => [
                        'namespace' => 'Wallbox\\Infrastructure\\Hyperf\\Provider',
                    ],
                ],
            ],
            'aggregate' => [
                'user' => [
                    'namespace' => 'Wallbox\\Infrastructure\\Hyperf\\Model',
                ],
                'repository' => [
                    'user' => [
                        'namespace' => 'Wallbox\\Infrastructure\\Hyperf\\Repository',
                    ],
                ],
            ],
            'view' => [
                'user' => [
                    'namespace' => 'Wallbox\\Infrastructure\\Hyperf\\View',
                ],
                'repository' => [
                    'user' => [
                        'namespace' => 'Wallbox\\Infrastructure\\Hyperf\\Repository',
                    ],
                ],
            ],
        ],
        'request' => [
            'namespace' => 'Wallbox\\UI\\Http\\Request',
        ]
    ],
];
