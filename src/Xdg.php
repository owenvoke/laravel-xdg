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
    public const S_IFDIR = 040000; // directory
    public const S_IRWXO = 00007;  // rwx other
    public const S_IRWXG = 00056;  // rwx group
    public const RUNTIME_DIR_FALLBACK = 'php-xdg-runtime-dir-fallback-';

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
        if ($directory = Env::get('XDG_RUNTIME_DIR')) {
            return $directory;
        }

        if (! $strict) {
            return $this->getFallbackDirectory();
        }

        throw XdgNotAvailableException::runtimeDirectoryNotAvailable();
    }

    /** @return Collection<int, string> */
    public function getDataDirectories(): Collection
    {
        if ($directories = Env::get('XDG_DATA_DIRS', '/etc/xdg')) {
            return Str::of($directories)
                ->explode(':')
                ->prepend($this->getHomeDataDirectory());
        }

        throw XdgNotAvailableException::dataDirectoriesNotAvailable();
    }

    /** @return Collection<int, string> */
    public function getConfigDirectories(): Collection
    {
        if ($directories = Env::get('XDG_CONFIG_DIRS', '/usr/local/share:/usr/share')) {
            return Str::of($directories)
                ->explode(':')
                ->prepend($this->getHomeConfigDirectory());
        }

        throw XdgNotAvailableException::configDirectoriesNotAvailable();
    }

    /** @link https://github.com/dnoegel/php-xdg-base-dir/blob/12f5b94710c8f5b504432d57ce353075fc434339/src/Xdg.php#L86 */
    private function getFallbackDirectory(): string
    {
        $fallback = sys_get_temp_dir().'/'.self::RUNTIME_DIR_FALLBACK.Env::get('USER');

        $create = false;

        if (! is_dir($fallback)) {
            mkdir($fallback, 0700, true);
        }

        $stats = lstat($fallback);

        # The fallback must be a directory
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
