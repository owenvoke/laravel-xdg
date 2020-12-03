<?php

declare(strict_types=1);

use OwenVoke\LaravelXdg\Facades\Xdg as XdgFacade;
use OwenVoke\LaravelXdg\Xdg;

it('can resolve an xdg instance from the container', function () {
    $this->assertInstanceOf(Xdg::class, $this->app->get('xdg'));
    $this->assertInstanceOf(Xdg::class, $this->app->get(Xdg::class));
});

it('can access facade methods', function () {
    putenv('HOME=/home/test');

    $this->assertSame('/home/test', XdgFacade::getHomeDirectory());
});
