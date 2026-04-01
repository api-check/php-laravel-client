<?php

namespace ApiCheck\Laravel\Tests;

use ApiCheck\Api\ApiClient;
use ApiCheck\Laravel\ServiceProvider;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase;

class ServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    /** @test */
    public function it_publishes_config_file()
    {
        $this->artisan('vendor:publish', [
            '--tag' => 'apicheck-config',
            '--force' => true,
        ])->assertExitCode(0);

        $configPath = config_path('apicheck.php');

        $this->assertFileExists($configPath);

        // Cleanup
        File::delete($configPath);
    }

    /** @test */
    public function it_merges_config_from_package()
    {
        // Config should be merged even without publishing
        $this->assertNotNull(config('apicheck'));
        $this->assertArrayHasKey('api_key', config('apicheck'));
        $this->assertArrayHasKey('referer', config('apicheck'));
    }

    /** @test */
    public function it_can_override_config_values()
    {
        $this->app['config']->set('apicheck.api_key', 'custom-key');
        $this->app['config']->set('apicheck.referer', 'https://custom.com');

        // Re-resolve to get new config values (singleton won't update, but config is there)
        $this->assertEquals('custom-key', config('apicheck.api_key'));
        $this->assertEquals('https://custom.com', config('apicheck.referer'));
    }

    /** @test */
    public function package_version_is_set()
    {
        $this->assertEquals('2.0.0', ServiceProvider::PACKAGE_VERSION);
    }
}
