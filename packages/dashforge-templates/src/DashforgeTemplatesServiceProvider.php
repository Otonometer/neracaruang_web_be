<?php

namespace Webcore\DashforgeTemplates;

use Illuminate\Support\ServiceProvider;

class DashforgeTemplatesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'dashforge-templates');

        /**
         * Publish templates assets
         */
        $this->publishes([
            __DIR__.'/../samples/public' => public_path(),
        ], 'public');

        /**
         * Publish all templates's views
         */
        $this->publishes([
            __DIR__.'/../samples/resources/views/auth' => base_path('resources/views/auth'),
            __DIR__.'/../samples/resources/views/layouts' => base_path('resources/views/layouts'),
            __DIR__.'/../samples/resources/views/vendor' => base_path('resources/views/vendor'),
            __DIR__.'/../samples/resources/views/dashboard.blade.php' => base_path('resources/views/dashboard.blade.php'),
            __DIR__.'/../samples/resources/views/home.blade.php' => base_path('resources/views/home.blade.php'),
            __DIR__.'/../samples/resources/views/welcome.blade.php' => base_path('resources/views/welcome.blade.php'),
        ], 'views');

        /**
         * Publish all templates's views
         */
        $this->publishes([
            __DIR__.'/../samples/resources/views' => base_path('resources/views'),
        ], 'views-all');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
