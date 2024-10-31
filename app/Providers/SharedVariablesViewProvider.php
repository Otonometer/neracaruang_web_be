<?php

namespace App\Providers;

use App\Enums\ContentTypes;
use App\Enums\SubjectTypes;
use App\Enums\LocationTypes;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SharedVariablesViewProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::share('contentTypesEnum',ContentTypes::class);
        View::share('subjectTypesEnum',SubjectTypes::class);
        View::share('locationTypesEnum',LocationTypes::class);
    }
}
