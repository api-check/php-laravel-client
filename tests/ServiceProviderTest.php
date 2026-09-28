<?php

namespace ApiCheck\Laravel\Tests;

use ApiCheck\Laravel\ServiceProvider;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    #[Test]
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

    #[Test]
    public function it_merges_config_from_package()
    {
        // Config should be merged even without publishing
        $this->assertNotNull(config('apicheck'));
        $this->assertArrayHasKey('api_key', config('apicheck'));
        $this->assertArrayHasKey('referer', config('apicheck'));
    }

    #[Test]
    public function it_merges_config_during_registration()
    {
        // Config must be available to other providers before this one boots
        $this->app['config']->set('apicheck', []);

        (new ServiceProvider($this->app))->register();

        $this->assertArrayHasKey('api_key', config('apicheck'));
    }

    #[Test]
    public function it_can_override_config_values()
    {
        $this->app['config']->set('apicheck.api_key', 'custom-key');
        $this->app['config']->set('apicheck.referer', 'https://custom.com');

        $this->assertEquals('custom-key', config('apicheck.api_key'));
        $this->assertEquals('https://custom.com', config('apicheck.referer'));
    }

    #[Test]
    public function package_version_is_semver()
    {
        $this->assertMatchesRegularExpression('/^\d+\.\d+\.\d+$/', ServiceProvider::PACKAGE_VERSION);
    }
}
