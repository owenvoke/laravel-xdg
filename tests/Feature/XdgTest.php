<?php

declare(strict_types=1);

use Illuminate\Support\Env;
use OwenVoke\LaravelXdg\Xdg;

it('can get the home directory', function () {
    putenv('HOME=/fake-dir');

    $this->assertSame('/fake-dir', app(Xdg::class)->getHomeDirectory());
});

it('can get the home cache directory', function () {
    putenv('XDG_CACHE_HOME=/fake-dir/.cache');

    $this->assertSame('/fake-dir/.cache', app(Xdg::class)->getHomeCacheDirectory());
});

it('can get the home config directory', function () {
    putenv('XDG_CONFIG_HOME=/fake-dir/.config');

    $this->assertSame('/fake-dir/.config', app(Xdg::class)->getHomeConfigDirectory());
});

it('can get the home data directory', function () {
    putenv('XDG_DATA_HOME=/fake-dir/.local/share');

    $this->assertSame('/fake-dir/.local/share', app(Xdg::class)->getHomeDataDirectory());
});

it('can get the runtime directory', function () {
    putenv('XDG_RUNTIME_DIR=/tmp/');

    $this->assertSame('/tmp/', app(Xdg::class)->getRuntimeDirectory());
});

it('can get the runtime directory with fallback', function () {
    putenv('XDG_RUNTIME_DIR=');

    $fallbackDirectory = sys_get_temp_dir().'/'.Xdg::RUNTIME_DIR_FALLBACK.Env::get('USER');

    $this->assertSame($fallbackDirectory, app(Xdg::class)->getRuntimeDirectory(false));
});

it('throws an exception on strict runtime when env does not exist', function () {
    putenv('XDG_RUNTIME_DIR=');

    app(Xdg::class)->getRuntimeDirectory(true);
})->throws(RuntimeException::class, 'Unable to get the XDG runtime directory');

it('can get the data directories', function () {
    putenv('XDG_DATA_HOME=/fake-dir/.local/share');

    $directories = app(Xdg::class)->getDataDirectories();

    $this->assertNotEmpty($directories);
    $this->assertSame('/fake-dir/.local/share', $directories->first());
});

it('can get the config directories', function () {
    putenv('XDG_CONFIG_HOME=/fake-dir/.config');

    $directories = app(Xdg::class)->getConfigDirectories();

    $this->assertNotEmpty($directories);
    $this->assertSame('/fake-dir/.config', $directories->first());
});
