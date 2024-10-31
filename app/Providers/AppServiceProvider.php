<?php

namespace App\Providers;

use App\Enums\ContentTypes;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(config('app.env') != 'local') {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('ismediacontent',fn(int $typeId) => in_array($typeId,ContentTypes::mediaContents()));
        if (config('app.env') != 'local') {
            if (config('app.force_https')) {
                $url->forceScheme('https');
            }
        }
    }
}
