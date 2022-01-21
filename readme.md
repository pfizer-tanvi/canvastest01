# [APP_NAME]

[![Web Build & Test (Deploy if mainline)](https://github.com/pfizer/stratus-core-laravel/actions/workflows/ci-web-php.yml/badge.svg)](https://github.com/pfizer/stratus-core-laravel/actions/workflows/ci-web-php.yml)

## Overview

See [https://docs.stratus.pfizer/docs/](https://docs.stratus.pfizer/docs/) for extensive docs

See [stratus.pfizer](stratus.pfizer) for support and more to manage the

See how deployments work [here](https://docs.stratus.pfizer/docs/working-with-projects/deploy_production/)


## Setup Local

Copy the .env.example file to .env

Make sure you have a database with the name `APP_NAME`

The local dev needs to run on https

The local dev url will be `https://APP_NAME.test`

See docs [here](https://laravel.com/docs/master/valet)
This is a great way to get going for Mac users.

For PC users, consider a minimal install of [XAMPP](https://www.apachefriends.org/faq_windows.html)

For js just run `npm install` and while working run `npm run watch`

We have pusher info for you on Stratus



## Builder Notes
please make sure to build staging, uat and production else it will not pass travis

make sure to run `aws/cloudformation-web-container-pt1.yml` for staging then

`aws/cloudformation-web-container-pt2.yml` for uat then production

Read the description in the fields to know how to get the AppId and
to know to come back and update the cognito password.

More info for the StackBuilder is in confluence under the updated docs COMING SOON


## Files

### Build Related
`exclude-patters.txt`
Assists in the zip work

`default.conf`
nginx settings if needed. Ask for assistance to change these

`filebeat-template.yml`
This is for the system to use during filebeat install

`supervisor-*`
This allows you to update the settings per environment


`.dockerignore`
Helps keep Docker small if we exclude folders and files

`aws` folder
This is a number of build scripts we use for the stack

### Docker
You do not need to run docker locally but if you choose to

`docker` folder see docker-composer.yml

`docker-compose.yml`
This is here to help you run docker more easily locally

### Lando (optional)
You can use [Lando](https://docs.lando.dev) to easily run your laravel apps
in docker with all the tooling you need to run them in the containers. That means
on a per app basis you can have different tooling, php versions, etc and they will
still work.

To use lando:

* `cp .env.example` to `.env.lando` and fill in the values according to the comments.
* `cp .lando.example.yml` to `.lando.yml` and fill in the values according to the comments.

Then you can lando start to get the app up and running.

```bash
lando start
```

To see all the tooling available in a Lando environment run:

```bash
lando
```

In particular to the `stratus-core-laravel` apps we get:

```bash
# Run php commands
lando php

# Run composer commands
lando composer

# Run artisan commands
lando artisan

# Drop into a mysql shell
lando mysql

# Run yarn|npm commands
lando yarn|npm

# Watch your css
lando watch
```

To stop lando run:

```bash
lando stop
```
