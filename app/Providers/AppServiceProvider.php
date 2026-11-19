<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // shouts at me whenever a page lazy-loads a relation (N+1)
        Model::preventLazyLoading(! app()->isProduction());
    }
}
