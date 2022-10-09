<?php

namespace ApiCheck\Laravel;

use ApiCheck\Api\ApiClient;
use Illuminate\Contracts\Container\Container;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    const PACKAGE_VERSION = '1.0';

    /**
     * Boot the service provider.
     * @return void
     */
    public function boot(): void
    {
        $this->setupConfig();
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register(): void
    {
        $this->registerApiClient();
        $this->registerApiAdapter();
        $this->registerManager();
    }

    /**
     * Setup the config.
     * @return void
     */
    protected function setupConfig(): void
    {
        $source = realpath(__DIR__ . '/../config/apicheck.php');

        // Check if the application is a Laravel or Lumen
        // instance to properly merge the configuration file.
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([ $source => config_path('apicheck.php') ]);
        } else if ($this->app instanceof LumenApplication) {
            $this->app->configure('apicheck');
        }

        $this->mergeConfigFrom($source, 'apicheck');
    }

    /**
     * Register the manager class.
     * @return void
     */
    protected function registerManager(): void
    {
        $this->app->singleton('apicheck', function (Container $app) {
            return new Manager($app);
        });

        $this->app->alias('apicheck', Manager::class);
    }

    /**
     * Register the ApiCheck API adapter class.
     * @return void
     */
    protected function registerApiAdapter(): void
    {
        $this->app->singleton('apicheck.api', function (Container $app) {
            $config = $app['config'];

            return new ApiClientAdapter($config, $app['apicheck.api.client']);
        });
    }

    /**
     * Register the ApiCheck API Client.
     * @return void
     */
    protected function registerApiClient(): void
    {
        $this->app->singleton('apicheck.api.client', function () {
            return (new ApiClient())->addVersionString('Laravel/' . self::PACKAGE_VERSION);
        });

        $this->app->alias('apicheck.api.client', ApiClient::class);
    }

    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides(): array
    {
        return [
            'apicheck',
            'apicheck.api',
            'apicheck.api.client'
        ];
    }
}