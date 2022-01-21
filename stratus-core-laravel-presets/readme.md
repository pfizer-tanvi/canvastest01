

Laravel presets first then our overwrites

for example lavavle/ui v7 has some new settings and layout we want that to win out then APPEND or update the correct sections with ours

## Installation
The end goal is to extract this to a composer package that can be installed by running `composer require pfizer/stratus-core-laravel-presets`
For purposes of testing this PR,we are temporary adding a path vcs  to the repositories section of the root composer.json
- Run `composer update pfizer/stratus-core-laravel-presets` to pull in the package
- And `php artisan stratus-core-laravel:install` to install the presets

## TODO Immediate

  [] remove SetupDeploymentCommand we can just get rid of this one
  [] remove api_token stuff we moved away from that
  [] report.json is not needed and should be deleted



## TODO lets make tickets

why do we have public/js/security.js why did we not wrap that in webpack


We need to inherit repositories
since composer can not do this we are stuck running a bash command to set up the new laravel install
That bash command would put these repositories in place as needed


[https://getcomposer.org/doc/faqs/why-can%27t-composer-load-repositories-recursively.md](https://getcomposer.org/doc/faqs/why-can%27t-composer-load-repositories-recursively.md)
```
For that you should rather look into Private Packagist which lets you configure all your private packages in one place, and avoids the slow-downs associated with inline V






## NOTES

`src/template` has numerous starter files