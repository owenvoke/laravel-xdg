<?php

declare(strict_types=1);

use OwenVoke\LaravelXdg\Facades\Xdg as XdgFacade;
use OwenVoke\LaravelXdg\Xdg;

it('can resolve an xdg instance from the container', function () {
    expect($this->app->get('xdg'))->toBeInstanceOf(Xdg::class);
    expect($this->app->get(Xdg::class))->toBeInstanceOf(Xdg::class);
});

it('can access facade methods', function () {
    putenv('HOME=/home/test');

    expect(XdgFacade::getHomeDirectory())->toBe('/home/test');
});
