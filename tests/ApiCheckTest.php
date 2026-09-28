<?php

namespace ApiCheck\Laravel\Tests;

use ApiCheck\Api\ApiClient;
use ApiCheck\Laravel\Exceptions\MissingApiKeyException;
use ApiCheck\Laravel\ServiceProvider;
use ApiCheck\Laravel\Facades\ApiCheck;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;

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

    #[Test]
    public function it_binds_the_api_client_as_singleton()
    {
        $client1 = app('apicheck');
        $client2 = app('apicheck');

        $this->assertInstanceOf(ApiClient::class, $client1);
        $this->assertSame($client1, $client2, 'ApiClient should be a singleton');
    }

    #[Test]
    public function it_binds_api_client_by_class_name()
    {
        $client = app(ApiClient::class);

        $this->assertInstanceOf(ApiClient::class, $client);
        $this->assertSame($client, app('apicheck'));
    }

    #[Test]
    public function facade_returns_api_client()
    {
        $this->assertInstanceOf(ApiClient::class, ApiCheck::getFacadeRoot());
    }

    #[Test]
    public function helper_returns_api_client()
    {
        $this->assertInstanceOf(ApiClient::class, apicheck());
        $this->assertSame(apicheck(), app('apicheck'));
    }

    #[Test]
    public function config_is_merged()
    {
        $this->assertEquals('test-api-key', config('apicheck.api_key'));
        $this->assertEquals('https://example.com', config('apicheck.referer'));
    }

    #[Test]
    public function it_throws_a_clear_exception_when_the_api_key_is_missing()
    {
        $this->app['config']->set('apicheck.api_key', null);

        $this->expectException(MissingApiKeyException::class);

        app(ApiClient::class);
    }

    #[Test]
    public function it_throws_a_clear_exception_when_the_api_key_is_empty()
    {
        $this->app['config']->set('apicheck.api_key', '');

        $this->expectException(MissingApiKeyException::class);

        app(ApiClient::class);
    }

    #[Test]
    public function it_resolves_without_a_referer()
    {
        $this->app['config']->set('apicheck.referer', null);

        $this->assertInstanceOf(ApiClient::class, app(ApiClient::class));
    }

    #[Test]
    public function service_provider_registers_singletons()
    {
        // Verify the service is properly registered
        $this->assertTrue($this->app->has(ApiClient::class));
        $this->assertTrue($this->app->has('apicheck'));
    }
}
