<?php

declare(strict_types=1);

namespace OwenVoke\LaravelXdg;

use Illuminate\Support\Collection;
use OwenVoke\LaravelXdg\Exceptions\XdgNotAvailableException;
use XdgBaseDir\Xdg as BaseXdg;

class Xdg
{
    private BaseXdg $xdg;

    public function __construct(BaseXdg $xdg)
    {
        $this->xdg = $xdg;
    }

    public function getHomeDirectory(): string
    {
        if ($directory = $this->xdg->getHomeDir()) {
            return $directory;
        }

        throw XdgNotAvailableException::homeDirectoryNotAvailable();
    }

    public function getHomeCacheDirectory(): string
    {
        if ($directory = $this->xdg->getHomeCacheDir()) {
            return $directory;
        }

        throw XdgNotAvailableException::homeCacheDirectoryNotAvailable();
    }

    public function getHomeConfigDirectory(): string
    {
        if ($directory = $this->xdg->getHomeConfigDir()) {
            return $directory;
        }

        throw XdgNotAvailableException::homeConfigDirectoryNotAvailable();
    }

    public function getHomeDataDirectory(): string
    {
        if ($directory = $this->xdg->getHomeDataDir()) {
            return $directory;
        }

        throw XdgNotAvailableException::homeDataDirectoryNotAvailable();
    }

    public function getRuntimeDirectory(bool $strict = true): string
    {
        if ($directory = $this->xdg->getRuntimeDir($strict)) {
            return $directory;
        }

        throw XdgNotAvailableException::runtimeDirectoryNotAvailable();
    }

    /** @return Collection<int, string> */
    public function getDataDirectories(): Collection
    {
        if ($directories = $this->xdg->getDataDirs()) {
            return collect($directories);
        }

        throw XdgNotAvailableException::dataDirectoriesNotAvailable();
    }

    /** @return Collection<int, string> */
    public function getConfigDirectories(): Collection
    {
        if ($directories = $this->xdg->getConfigDirs()) {
            return collect($directories);
        }

        throw XdgNotAvailableException::configDirectoriesNotAvailable();
    }
}