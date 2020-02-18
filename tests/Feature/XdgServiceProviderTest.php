<?php

declare(strict_types=1);

namespace OwenVoke\LaravelXdg\Tests\Feature;

use OwenVoke\LaravelXdg\Facades\Xdg as XdgFacade;
use OwenVoke\LaravelXdg\Tests\AbstractTestCase;
use OwenVoke\LaravelXdg\Xdg;

class XdgServiceProviderTest extends AbstractTestCase
{
    /** @test */
    public function it_can_resolve_an_xdg_instance_from_the_container(): void
    {
        $this->assertInstanceOf(Xdg::class, $this->app->get('xdg'));
        $this->assertInstanceOf(Xdg::class, $this->app->get(Xdg::class));
    }

    /** @test */
    public function it_can_access_facade_methods(): void
    {
        putenv('HOME=/home/test');

        $this->assertSame('/home/test', XdgFacade::getHomeDirectory());
    }
}
