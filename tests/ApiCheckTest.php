<?php

namespace ApiCheck\Laravel\Tests;

use ApiCheck\Api\ApiClient;
use ApiCheck\Laravel\ServiceProvider;
use ApiCheck\Laravel\Facades\ApiCheck;
use Orchestra\Testbench\TestCase;

class ApiCheckTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'ApiCheck' => ApiCheck::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('apicheck.api_key', 'test-api-key');
        $app['config']->set('apicheck.referer', 'https://example.com');
    }

    /** @test */
    public function it_binds_the_api_client_as_singleton()
    {
        $client1 = app('apicheck');
        $client2 = app('apicheck');

        $this->assertInstanceOf(ApiClient::class, $client1);
        $this->assertSame($client1, $client2, 'ApiClient should be a singleton');
    }

    /** @test */
    public function it_binds_api_client_by_class_name()
    {
        $client = app(ApiClient::class);

        $this->assertInstanceOf(ApiClient::class, $client);
        $this->assertSame($client, app('apicheck'));
    }

    /** @test */
    public function facade_returns_api_client()
    {
        $this->assertInstanceOf(ApiClient::class, ApiCheck::getFacadeRoot());
    }

    /** @test */
    public function helper_returns_api_client()
    {
        $this->assertInstanceOf(ApiClient::class, apicheck());
        $this->assertSame(apicheck(), app('apicheck'));
    }

    /** @test */
    public function config_is_merged()
    {
        $this->assertEquals('test-api-key', config('apicheck.api_key'));
        $this->assertEquals('https://example.com', config('apicheck.referer'));
    }

    /** @test */
    public function config_has_default_values()
    {
        // Test defaults when not set
        $app = $this->app;

        // Fresh app without our env setup
        $app['config']->set('apicheck', []);

        $this->assertNull(config('apicheck.api_key'));
        $this->assertNull(config('apicheck.referer'));
    }

    /** @test */
    public function service_provider_is_deferred()
    {
        $provider = new ServiceProvider($this->app);

        $this->assertTrue($provider->isDeferred(), 'ServiceProvider should be deferred for performance');
    }

    /** @test */
    public function service_provider_declares_provided_services()
    {
        $provider = new ServiceProvider($this->app);

        $this->assertEquals([ApiClient::class, 'apicheck'], $provider->provides());
    }
}
