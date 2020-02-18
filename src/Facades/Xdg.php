<?php

declare(strict_types=1);

namespace OwenVoke\LaravelXdg\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string getHomeDirectory()
 * @method static string getHomeCacheDirectory()
 * @method static string getHomeConfigDirectory()
 * @method static string getHomeDataDirectory()
 * @method static string getRuntimeDirectory()
 * @method static \Illuminate\Support\Collection<int, string> getDataDirectories()
 * @method static \Illuminate\Support\Collection<int, string> getConfigDirectories()
 *
 * @see \OwenVoke\LaravelXdg\Xdg
 */
class Xdg extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'xdg';
    }
}
