<?php

return [
    'cache' => [
        'default' => env('CACHE_DRIVER', 'database'),
    ],

    'session' => [
        'driver' => env('SESSION_DRIVER', 'database'),
        'expire_on_close' => true,
        'encrypt' => true,
    ],

    'filesystem' => [
        'disks' => [
            's3' => [
                'region' => env('AWS_REGION', 'eu-west-1'),
                'bucket' => sprintf('%s-%s', env('ACCOUNT_NAME'), env('APP_NAME')),
            ],
        ],
    ],

    'services' => [
        'fargate' => [
            'libraries' => [
                'app_env' => env('FARGATE_LIBRARY_APP_ENV', 'staging'),
                'aws_region' => 'us-east-1',
            ],
        ],
    ],
    'mail' => [
        'host' => env('MAIL_HOST', 'email-smtp.us-east-1.amazonaws.com'),
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS', 'noreply@smartsuite.digitalpfizer.com'),
            'name' => env('MAIL_FROM_NAME', 'CAT Platform'),
        ],
    ],
    'logging' => [
        'channels' => [
            'json' => [
                'driver' => 'monolog',
                'level' => 'debug',
                'handler' => StreamHandler::class,
                'with' => [
                    'stream' => storage_path('logs/laravel.log.json'),
                ],
                'formatter' => Monolog\Formatter\JsonFormatter::class,
            ],
        ],
    ],
    'queue' => [
        'connections' => [
            'sqs' => [
                'prefix' => vsprintf('https://sqs.%s.amazonaws.com/%s', [
                    env('AWS_REGION'),
                    env('ACCOUNT_ID', 364215618558),
                ]),
                'queue' => sprintf('%s-default-%s', env('APP_NAME'), env('APP_ENV')),
                'region' => env('AWS_DEFAULT_REGION', 'eu-west-1'),
            ],
        ],
    ],
];
