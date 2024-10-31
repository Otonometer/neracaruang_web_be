Dashforge templates for Webcore
==============================

For https://github.com/dandisy/webcore


### Usage (if this package is installed manually)

0. copy the dashforge-templates sourcecode to vendor/dandisy

1. Make sure the folder name is dashforge-templates (not dashforge-templates-master or other)

2. add autoload classmap in composer.json

    {
        . . .
        "autoload": {
            "classmap": [
                . . .
                "vendor/dandisy"
            ],
            . . .

3. register this package in config/app.php

    /*
    * Package Service Providers...
    */
    . . .    
    Webcore\DashforgeTemplates\DashforgeTemplatesServiceProvider::class,

4. composer dump-autoload
5. publish the templates package to webcore project

    php artisan vendor:publish --provider="Webcore\DashforgeTemplates\DashforgeTemplatesServiceProvider" --tag="public"

    php artisan vendor:publish --provider="Webcore\DashforgeTemplates\DashforgeTemplatesServiceProvider" --tag="views"

    or

    php artisan vendor:publish --provider="Webcore\DashforgeTemplates\DashforgeTemplatesServiceProvider" --tag="views-all"

    or

    php artisan vendor:publish --provider="Webcore\DashforgeTemplates\DashforgeTemplatesServiceProvider" --force

6. change templates configuration in config/webcore/laravel_generator.php to dashforge-templates

    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    |
    */

    // 'templates'         => 'adminlte-templates',
    // 'templates'         => 'dashforge-templates',