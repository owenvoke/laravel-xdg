<?php

declare(strict_types=1);

namespace OwenVoke\LaravelXdg;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class XdgServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton('xdg', Xdg::class);

        $this->app->alias(Xdg::class, 'xdg');
    }

    /** @return array<int, string> */
    public function provides(): array
    {
        return ['xdg', Xdg::class];
    }
}
