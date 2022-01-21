# ADR-001 Base install using library


## Context
Instead of directly patching Laravel we are going to use an external library to update it and patch it as needed.


## Decision

https://github.com/pfizer/stratus-core-laravel

But then we do a lot of patching to it.

For one we pull in [https://github.com/pfizer/security-audit-laravel](https://github.com/pfizer/security-audit-laravel) and apply some of the patches.

For example it adds https://github.com/pfizer/security-audit-laravel#timeout-session-in-15-minutes
and https://github.com/pfizer/security-audit-laravel#javascript

But let's make this part of our `stratus-core-laravel-presets` `StratusCoreLaravelPresets`  repo

That when we install `stratus-core-laravel` (this repo) it includes these patches and the needed composer hooks and
artisan commands to publish all the needed settings.

We need to make sure all our current .env expectations match the latest of laravel for example renamed `MAIL_DRIVER` to `MAIL_MAILER` and we need to move forward with them.

We need to then put in place our `.travis.yml` file which can be included in our library and copied over.

Some this can be seen in [Custom Presets Video Here](https://laracasts.com/series/how-to-create-custom-presets)

Turn off password `reset` most of our work needs Cognito so all our auth should default to what we see [pfizer/cognito-auth-php](composer.json)

## Existing Libraries We Require (latest)

We never pull in `dev-master` we want to pin the MAJOR version

These will all lead to additions to the default Laravel build


Our install needs to be setup for database driven sessions and cache
so we need to run those artisan commands scripts.

We can easily have a hook in our library that works with composer.json
`post-root-package-install` step.




### aws/aws-sdk-php

We alter the following

`config/filesystems.php`

```

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_REGION', 'eu-west-1'),
            'bucket' => env('ACCOUNT_NAME') . '-' . env('APP_NAME'),
            'url' => env('AWS_URL'),
        ],
```


`config/services.php`

```
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'fargate' => [
        "libraries" => [
            'app_env' => env("FARGATE_LIBRARY_APP_ENV", 'staging'),
            'aws_region' => 'us-east-1'
        ]
    ]
```

`config/sessions.php`

set default
```
    'driver' => env('SESSION_DRIVER', 'database'),
    'expire_on_close' => true,
    'encrypt' => true,

```

### sqs-plain

This library added `https://github.com/mehr-it/lara-sqs-plain`

We want to be able to take jobs from non Laravel


### doctrine/dbal

needs to be included


### friendsofcat/laravel-feature-flag

`config/app.php` so our preset library should include this in it's
services registration so that when it is automatically discovered
by Laravel these will be included too.

```
        FriendsOfCat\LaravelFeatureFlags\FeatureFlagsProvider::class,
```

### league/flysystem-aws-s3-v3

The publish command should include `config/laravel-feature-flag.php`


### pfizer/cognito-auth-php
`config/app.php` so our preset library should include this in it's
services registration so that when it is automatically discovered
by Laravel these will be included too.

```
Pfizer\CognitoAuthLaravel\CognitoAuthLaravelServiceProvider::class
```
The publish command should put this into place
`config/cognito.php`


We then up the `routes/web.php` as such:

//look up the false feature
//to remove all auth routes but
//login and logout
```
Auth::routes(
    [
        'register' => false,
        'password-reset' => false
    ]);
```

### Javascript
we go with Laravels `laravel/ui`
and we default to VueJs
We then add the following

#### Testing Setup
using how they do things
https://github.com/laravel/ui/blob/2.x/src/Presets/Vue.php
we need t update our package.json



```
    "scripts": {
        "test": "jest",
        "dev": "npm run development",
        "development": "cross-env NODE_ENV=development node_modules/webpack/bin/webpack.js --progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js",
        "watch": "npm run development -- --watch",
        "watch-poll": "npm run watch -- --watch-poll",
        "hot": "cross-env NODE_ENV=development node_modules/webpack-dev-server/bin/webpack-dev-server.js --inline --hot --config=node_modules/laravel-mix/setup/webpack.config.js",
        "prod": "npm run production",
        "production": "cross-env NODE_ENV=production node_modules/webpack/bin/webpack.js --no-progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js"
    },
    "jest": {
        "moduleFileExtensions": [
            "js",
            "json",
            "vue"
        ],
        "transform": {
            ".*\\.(vue)$": "vue-jest",
            "^.+\\.js$": "<rootDir>/node_modules/babel-jest"
        },
        "moduleNameMapper": {
            "^@/(.*)$": "<rootDir>/resources/js/$1"
        },
        "setupFiles": [
            "<rootDir>/resources/js/tests/setup.js"
        ]
    },

    "devDependencies": {
        //tons of jest in here
    }
```

We add other vue + js stuff `dependencies` and `devDependencies`
has all the things we need.

We need to try though to not downgrade their JS files

so we can starting today make sure our preset goals line up with their
version of the libraries

For example our `vuex` addition should line up with the latest `vue` installed.




### Logging

`config/logging.php`

```

        'json' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => storage_path('logs/laravel.log.json'),
            ],
            'formatter' => Monolog\Formatter\JsonFormatter::class,
        ],
```


### pfizer/security-audit-laravel

`config/app.php` so our preset library should include this in it's
services registration so that when it is automatically discovered
by Laravel these will be included too.

```
Pfizer\SecurityAudit\SecurityAuditProvider::class,
```

### pusher/pusher-php-server

### squizlabs/php_codesniffer (dev section of composer)

### pfizer/cat-quality-script (dev section of composer)

### codedungeon/phpunit-result-printer (dev section of composer)

### files
any file in the root of this needs to be part of your package




## Starting off



>Some have to be pulled in as below

```    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/pfizer/cognito-auth-php.git"
        },
        {
            "type": "vcs",
            "url": "https://github.com/pfizer/cat-quality-script.git"
        },
        {
            "type": "vcs",
            "url": "https://github.com/pfizer/security-audit-laravel.git"
        },
        {
            "type": "vcs",
            "url": "https://github.com/pfizer/support-widget"
        }
    ],
```

### composer.json

Scripts Section. Do we inject these or inherit them from our `composer.json`
or if not make them artisan commands and then we need to fix our `travis.yaml` file


```
        "check-style": "phpcs -p --standard=PSR2 --runtime-set ignore_errors_on_exit 1 --runtime-set ignore_warnings_on_exit 1 app",
        "fix-style": "phpcbf -p --standard=PSR2 --runtime-set ignore_errors_on_exit 1 --runtime-set ignore_warnings_on_exit 1 app",
        "check-metrics": "phpmetrics --report-json=report.json app && vendor/bin/quality_run_check.py report.json",
        "check-metrics-html": "phpmetrics --report-json=report.json --report-html=report app && open report/index.html",
        "check-phpstan": "php artisan code:analyse --paths=app --level=0"
```

### Mail

`config/mail.php`

```
    'host' => env('MAIL_HOST', 'email-smtp.us-east-1.amazonaws.com'),
    ///
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'noreply@smartsuite.digitalpfizer.com'),
        'name' => env('MAIL_FROM_NAME', "CAT Platform"),
    ],
```

### queue settings

```
        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => 'https://sqs.' . env("AWS_REGION") . '.amazonaws.com/' . env("ACCOUNT_ID", 364215618558),
            'queue' => env('APP_NAME') . '-default-' . env('APP_ENV'),
            'region' => env('AWS_REGION', 'eu-west-1'),
        ],
```


## Status
- [ ] <img  style="width: 20px;height: 22px;" src="https://github.global.ssl.fastly.net/images/icons/emoji/bulb.png?v8" /> Proposed on YYYY-MM-DD
- [ ] <img  style="width: 20px;height: 22px;" src="https://github.global.ssl.fastly.net/images/icons/emoji/white_check_mark.png?v8" /> Accepted on YYYY-MM-DD
- [ ] <img  style="width: 20px;height: 22px;" src="https://github.global.ssl.fastly.net/images/icons/emoji/no_entry.png?v8" /> Depreciated on YYYY-MM-DD
- [ ] <img  style="width: 20px;height: 22px;" src="https://github.global.ssl.fastly.net/images/icons/emoji/arrow_heading_up.png?v8" /> Superseded by [ADR-NNN](#)


## Consequences
<!-- This section describes the resulting context, after applying the decision. All consequences should be listed here, not just the "positive" ones. A particular decision may have positive, negative, and neutral consequences, but all of them affect the team and project in the future. -->