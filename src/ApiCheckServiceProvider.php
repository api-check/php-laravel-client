<?php

namespace ApiCheck\Laravel ;

use Illuminate\Support\ServiceProvider;

class ApiCheckServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('apicheck.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'apicheck');

        $this->app->singleton('apicheck', function () {
            return new ApiCheck;
        });
    }
}
