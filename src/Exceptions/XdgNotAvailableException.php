<?php

declare(strict_types=1);

namespace OwenVoke\LaravelXdg\Exceptions;

use RuntimeException;

class XdgNotAvailableException extends RuntimeException
{
    public static function homeDirectoryNotAvailable(): self
    {
        return new self('Unable to get the XDG home directory');
    }

    public static function homeCacheDirectoryNotAvailable(): self
    {
        return new self('Unable to get the XDG home cache directory');
    }

    public static function homeConfigDirectoryNotAvailable(): self
    {
        return new self('Unable to get the XDG home config directory');
    }

    public static function homeDataDirectoryNotAvailable(): self
    {
        return new self('Unable to get the XDG home data directory');
    }

    public static function runtimeDirectoryNotAvailable(): self
    {
        return new self('Unable to get the XDG runtime directory');
    }

    public static function dataDirectoriesNotAvailable(): self
    {
        return new self('Unable to get the XDG runtime directory');
    }

    public static function configDirectoriesNotAvailable(): self
    {
        return new self('Unable to get the XDG runtime directory');
    }
}
