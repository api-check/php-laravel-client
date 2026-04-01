<?php

namespace ApiCheck\Laravel\Tests;

use ApiCheck\Api\ApiClient;
use ApiCheck\Laravel\Facades\ApiCheck;
use ApiCheck\Laravel\ServiceProvider;
use Orchestra\Testbench\TestCase;

class FacadeTest extends TestCase
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
    }

    /** @test */
    public function facade_returns_same_instance_as_container()
    {
        $facadeRoot = ApiCheck::getFacadeRoot();
        $containerInstance = app('apicheck');

        $this->assertSame($facadeRoot, $containerInstance, 'Facade should resolve to apicheck binding');
    }

    /** @test */
    public function facade_can_call_get_api_version()
    {
        $version = ApiCheck::getApiVersion();

        $this->assertEquals('v1', $version);
    }

    /** @test */
    public function facade_provides_correct_method_signatures()
    {
        $client = ApiCheck::getFacadeRoot();

        // Verify all expected methods exist
        $methods = [
            'setApiKey',
            'setReferer',
            'getApiVersion',
            'lookup',
            'getNumberAdditions',
            'search',
            'globalSearch',
            'searchLocality',
            'searchMunicipality',
            'searchAddress',
            'getSupportedSearchCountries',
            'verifyEmail',
            'verifyPhone',
        ];

        foreach ($methods as $method) {
            $this->assertTrue(
                method_exists($client, $method),
                "Method {$method} should exist on ApiClient"
            );
        }
    }

    /** @test */
    public function facade_can_be_swapped_for_testing()
    {
        $mock = $this->createMock(ApiClient::class);

        ApiCheck::swap($mock);

        $this->assertSame($mock, ApiCheck::getFacadeRoot());
    }

    /** @test */
    public function facade_can_be_spied_for_testing()
    {
        $spy = ApiCheck::spy();

        // Facade::spy() returns a Mockery spy
        $this->assertInstanceOf(\Mockery\MockInterface::class, $spy);
    }
}
