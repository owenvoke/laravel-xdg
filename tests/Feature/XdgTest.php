<?php

declare(strict_types=1);

namespace OwenVoke\LaravelXdg\Tests\Feature;

use Illuminate\Support\Env;
use OwenVoke\LaravelXdg\Tests\AbstractTestCase;
use OwenVoke\LaravelXdg\Xdg;
use RuntimeException;

class XdgTest extends AbstractTestCase
{
    /** @test */
    public function it_can_get_the_home_directory(): void
    {
        putenv('HOME=/fake-dir');

        $this->assertSame('/fake-dir', $this->getXdg()->getHomeDirectory());
    }

    /** @test */
    public function it_can_get_the_home_cache_directory(): void
    {
        putenv('XDG_CACHE_HOME=/fake-dir/.cache');

        $this->assertSame('/fake-dir/.cache', $this->getXdg()->getHomeCacheDirectory());
    }

    /** @test */
    public function it_can_get_the_home_config_directory(): void
    {
        putenv('XDG_CONFIG_HOME=/fake-dir/.config');

        $this->assertSame('/fake-dir/.config', $this->getXdg()->getHomeConfigDirectory());
    }

    /** @test */
    public function it_can_get_the_home_data_directory(): void
    {
        putenv('XDG_DATA_HOME=/fake-dir/.local/share');

        $this->assertSame('/fake-dir/.local/share', $this->getXdg()->getHomeDataDirectory());
    }

    /** @test */
    public function it_can_get_the_runtime_directory(): void
    {
        putenv('XDG_RUNTIME_DIR=/tmp/');

        $this->assertSame('/tmp/', $this->getXdg()->getRuntimeDirectory());
    }

    /** @test */
    public function it_can_get_the_runtime_directory_with_fallback(): void
    {
        putenv('XDG_RUNTIME_DIR=');

        $fallbackDirectory = sys_get_temp_dir().'/'.Xdg::RUNTIME_DIR_FALLBACK.Env::get('USER');

        $this->assertSame($fallbackDirectory, $this->getXdg()->getRuntimeDirectory(false));
    }

    /** @test */
    public function it_throws_an_exception_on_strict_runtime_when_env_does_not_exist(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unable to get the XDG runtime directory');

        putenv('XDG_RUNTIME_DIR=');

        $this->getXdg()->getRuntimeDirectory(true);
    }

    /** @test */
    public function it_can_get_the_data_directories(): void
    {
        putenv('XDG_DATA_HOME=/fake-dir/.local/share');

        $directories = $this->getXdg()->getDataDirectories();

        $this->assertNotEmpty($directories);
        $this->assertSame('/fake-dir/.local/share', $directories->first());
    }

    /** @test */
    public function it_can_get_the_config_directories(): void
    {
        putenv('XDG_CONFIG_HOME=/fake-dir/.config');

        $directories = $this->getXdg()->getConfigDirectories();

        $this->assertNotEmpty($directories);
        $this->assertSame('/fake-dir/.config', $directories->first());
    }

    private function getXdg(): Xdg
    {
        return app(Xdg::class);
    }
}
