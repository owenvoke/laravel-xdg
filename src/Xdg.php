<?php

declare(strict_types=1);

namespace OwenVoke\LaravelXdg;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use OwenVoke\LaravelXdg\Exceptions\XdgNotAvailableException;

class Xdg
{
    public const S_IFDIR = 040000; // directory
    public const S_IRWXO = 00007;  // rwx other
    public const S_IRWXG = 00056;  // rwx group
    public const RUNTIME_DIR_FALLBACK = 'php-xdg-runtime-dir-fallback-';

    public function getHomeDirectory(): string
    {
        if ($directory = getenv('HOME')) {
            return $directory;
        }

        if (($homeDrive = getenv('HOMEDRIVE')) && ($homePath = getenv('HOMEPATH'))) {
            return "{$homeDrive}/{$homePath}";
        }

        throw XdgNotAvailableException::homeDirectoryNotAvailable();
    }

    public function getHomeCacheDirectory(): string
    {
        if ($directory = getenv('XDG_CACHE_HOME')) {
            return $directory;
        }

        if ($homeDirectory = $this->getHomeDirectory()) {
            return "{$homeDirectory}/.cache";
        }

        throw XdgNotAvailableException::homeCacheDirectoryNotAvailable();
    }

    public function getHomeConfigDirectory(): string
    {
        if ($directory = getenv('XDG_CONFIG_HOME')) {
            return $directory;
        }

        if ($homeDirectory = $this->getHomeDirectory()) {
            return $homeDirectory === DIRECTORY_SEPARATOR ? "{$homeDirectory}.config" : "{$homeDirectory}/.config";
        }

        throw XdgNotAvailableException::homeConfigDirectoryNotAvailable();
    }

    public function getHomeDataDirectory(): string
    {
        if ($directory = getenv('XDG_DATA_HOME')) {
            return $directory;
        }

        if ($homeDirectory = $this->getHomeDirectory()) {
            return "{$homeDirectory}/.local/share";
        }

        throw XdgNotAvailableException::homeDataDirectoryNotAvailable();
    }

    public function getRuntimeDirectory(bool $strict = true): string
    {
        if ($directory = getenv('XDG_RUNTIME_DIR')) {
            return $directory;
        }

        if (! $strict) {
            return $this->getFallbackDirectory();
        }

        throw XdgNotAvailableException::runtimeDirectoryNotAvailable();
    }

    /** @return Collection<int, string> */
    public function getConfigDirectories(): Collection
    {
        return Str::of(getenv('XDG_CONFIG_DIRS') ?: '/etc/xdg')
            ->explode(':')
            ->prepend($this->getHomeConfigDirectory());
    }

    /** @return Collection<int, string> */
    public function getDataDirectories(): Collection
    {
        return Str::of(getenv('XDG_DATA_DIRS') ?: '/usr/local/share:/usr/share')
            ->explode(':')
            ->prepend($this->getHomeDataDirectory());
    }

    /** @link https://github.com/dnoegel/php-xdg-base-dir/blob/12f5b94710c8f5b504432d57ce353075fc434339/src/Xdg.php#L86 */
    private function getFallbackDirectory(): string
    {
        $fallback = sys_get_temp_dir().'/'.self::RUNTIME_DIR_FALLBACK.getenv('USER');

        $create = false;

        if (! is_dir($fallback)) {
            mkdir($fallback, 0700, true);
        }

        $stats = lstat($fallback);

        // The fallback must be a directory
        if (! $stats['mode'] & self::S_IFDIR) {
            rmdir($fallback);
            $create = true;
        } elseif ($stats['mode'] & (self::S_IRWXO | self::S_IRWXG) || $stats['uid'] !== $this->getUuid()) {
            rmdir($fallback);
            $create = true;
        }

        if ($create) {
            mkdir($fallback, 0700, true);
        }

        return $fallback;
    }

    private function getUuid(): int
    {
        return function_exists('posix_getuid') ? posix_getuid() : getmyuid();
    }
}
