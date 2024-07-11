<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class SimilarityEngineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('similarityEngines', function () {
            return $this->loadEngines();
        });
    }

    public function loadEngines(): array
    {
        $engines = [];

        // Scan Services directory for engines
        $servicesDir = app_path('Services\Similarity');
        $files = scandir($servicesDir);

        foreach ($files as $file) {
            if (str_contains($file, '.php')) {
                // Extract engine name from file name
                $engineName = str_replace('.php', '', $file);
                $engineClass = 'App\\Services\\Similarity\\' . $engineName;
                $engines[] = app()->make($engineClass);
            }
        }

        return $engines;
    }
}
