<?php

namespace Kangangga\Emitter;

use Illuminate\Events\QueuedClosure;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class EmitterServiceProvider extends ServiceProvider
{

    private function queueable(\Closure $closure)
    {
        return new QueuedClosure($closure);
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('emitter.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'emitter');
        $this->app->singleton('emitter', function () {
            return new Emitter;
        });
        // $this->app->booting(function () {
        //     $loader = AliasLoader::getInstance();
        //     $loader->alias('Emitter', 'Kangangga\Emitter\EmitterFacade');
        // });
    }
}
