<?php

declare(strict_types=1);

namespace OwenVoke\LaravelXdg\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use OwenVoke\LaravelXdg\XdgServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            XdgServiceProvider::class,
        ];
    }
}
