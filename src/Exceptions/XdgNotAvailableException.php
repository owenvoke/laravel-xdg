<?php

declare(strict_types=1);

namespace OwenVoke\LaravelXdg\Exceptions;

use RuntimeException;

class XdgNotAvailableException extends RuntimeException
{
    public static function directoryNotAvailable(string $directoryName): self
    {
        return new self('Unable to get the XDG '.$directoryName.' directory');
    }

    public static function directoriesNotAvailable(string $directoryName): self
    {
        return new self('Unable to get the XDG '.$directoryName.' directories');
    }
}
