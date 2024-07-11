<?php

namespace App\Providers;

use App\Services\Generator\ColesRouteGenerator;
use App\Services\Generator\WoolworthRouteGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WoolworthRouteGenerator::class, function ($app) {
            return new WoolworthRouteGenerator();
        });

        $this->app->bind(ColesRouteGenerator::class, function ($app) {
            return new ColesRouteGenerator();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
