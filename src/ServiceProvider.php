<?php

namespace ApiCheck\Laravel;

use ApiCheck\Api\ApiClient;
use ApiCheck\Laravel\Exceptions\MissingApiKeyException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Package version.
     */
    public const PACKAGE_VERSION = '2.1.0';

    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([$this->configPath() => config_path('apicheck.php')], 'apicheck-config');
        }
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->configPath(), 'apicheck');

        $this->registerApiClient();
    }

    /**
     * Get the path to the package configuration file.
     */
    protected function configPath(): string
    {
        return realpath(__DIR__ . '/../config/apicheck.php');
    }

    /**
     * Register the ApiCheck API Client.
     */
    protected function registerApiClient(): void
    {
        $this->app->singleton(ApiClient::class, function (Container $app) {
            $apiKey = $app['config']->get('apicheck.api_key');

            if (! is_string($apiKey) || $apiKey === '') {
                throw MissingApiKeyException::create();
            }

            $client = new ApiClient();
            $client->setApiKey($apiKey);

            if ($referer = $app['config']->get('apicheck.referer')) {
                $client->setReferer($referer);
            }

            return $client;
        });

        $this->app->alias(ApiClient::class, 'apicheck');
    }
}
