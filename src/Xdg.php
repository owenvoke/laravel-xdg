<?php

declare(strict_types=1);

namespace OwenVoke\LaravelXdg;

use Illuminate\Support\Collection;
use Illuminate\Support\Env;
use Illuminate\Support\Str;
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
        if ($directory = Env::get('HOME')) {
            return $directory;
        }

        if (($homeDrive = Env::get('HOMEDRIVE')) && ($homePath = Env::get('HOMEPATH'))) {
            return "{$homeDrive}/{$homePath}";
        }

        throw XdgNotAvailableException::homeDirectoryNotAvailable();
    }

    public function getHomeCacheDirectory(): string
    {
        if ($directory = Env::get('XDG_CACHE_HOME')) {
            return $directory;
        }

        if ($homeDirectory = $this->getHomeDirectory()) {
            return "{$homeDirectory}/.cache";
        }

        throw XdgNotAvailableException::homeCacheDirectoryNotAvailable();
    }

    public function getHomeConfigDirectory(): string
    {
        if ($directory = Env::get('XDG_CONFIG_HOME')) {
            return $directory;
        }

        if ($homeDirectory = $this->getHomeDirectory()) {
            return $homeDirectory === DIRECTORY_SEPARATOR ? "{$homeDirectory}.config" : "{$homeDirectory}/.config";
        }

        throw XdgNotAvailableException::homeConfigDirectoryNotAvailable();
    }

    public function getHomeDataDirectory(): string
    {
        if ($directory = Env::get('XDG_DATA_HOME')) {
            return $directory;
        }

        if ($homeDirectory = $this->getHomeDirectory()) {
            return "{$homeDirectory}/.local/share";
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
