<?php

namespace ApiCheck\Laravel\Tests;

use ApiCheck\Api\ApiClient;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;

class HelperTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [\ApiCheck\Laravel\ServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('apicheck.api_key', 'test-key');
    }

    #[Test]
    public function apicheck_helper_exists()
    {
        $this->assertTrue(function_exists('apicheck'), 'The apicheck() helper should exist');
    }

    #[Test]
    public function apicheck_helper_returns_api_client()
    {
        $client = apicheck();

        $this->assertInstanceOf(ApiClient::class, $client);
    }

    #[Test]
    public function apicheck_helper_returns_singleton()
    {
        $client1 = apicheck();
        $client2 = apicheck();

        $this->assertSame($client1, $client2, 'Helper should return the same singleton instance');
    }

    #[Test]
    public function apicheck_helper_allows_method_calls()
    {
        $client = apicheck();

        // Test that we can call methods from the underlying client
        $this->assertIsString($client->getApiVersion());
        $this->assertEquals('v1', $client->getApiVersion());
    }
}
