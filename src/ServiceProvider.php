<?php

namespace ApiCheck\Laravel;

use ApiCheck\Api\ApiClient;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Package version.
     */
    public const PACKAGE_VERSION = '2.0.0';

    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        $this->setupConfig();
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerApiClient();
    }

    /**
     * Setup the configuration.
     */
    protected function setupConfig(): void
    {
        $source = realpath(__DIR__ . '/../config/apicheck.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('apicheck.php')], 'apicheck-config');
        }

        $this->mergeConfigFrom($source, 'apicheck');
    }

    /**
     * Register the ApiCheck API Client.
     */
    protected function registerApiClient(): void
    {
        $this->app->singleton(ApiClient::class, function (Container $app) {
            $client = new ApiClient();
            $client->setApiKey($app['config']->get('apicheck.api_key'));

            if ($referer = $app['config']->get('apicheck.referer')) {
                $client->setReferer($referer);
            }

            return $client;
        });

        $this->app->alias(ApiClient::class, 'apicheck');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [ApiClient::class, 'apicheck'];
    }
}
