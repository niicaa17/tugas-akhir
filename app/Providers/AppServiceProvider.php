<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Pada hosting InfinityFree, folder public ada di parent directory
        // htdocs/ = public, htdocs/app-files/ = base app
        if ($this->app->environment('production')) {
            $this->app->usePublicPath(base_path('../'));
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pakai pagination Bootstrap 5 supaya konsisten dengan tema admin
        Paginator::useBootstrapFive();
    }
}
