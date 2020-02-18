<?php

declare(strict_types=1);

namespace OwenVoke\LaravelXdg\Tests;

use Orchestra\Testbench\TestCase;
use OwenVoke\LaravelXdg\XdgServiceProvider;

abstract class AbstractTestCase extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            XdgServiceProvider::class,
        ];
    }
}
