# Laravel XDG

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-github-actions]][link-github-actions]
[![Style CI][ico-styleci]][link-styleci]
[![Total Downloads][ico-downloads]][link-downloads]
[![Buy us a tree][ico-treeware-gifting]][link-treeware-gifting]

A Laravel adapter for the XDG Base Directory specification.

## Install

Via Composer

```bash
$ composer require owenvoke/laravel-xdg
```

## Usage

```php
use OwenVoke\LaravelXdg\Xdg;

// Resolving from the app container
app(Xdg::class)->getHomeDirectory();
app('xdg')->getHomeDirectory();

// Using the facade (with, and without the short alias)
\Xdg::getHomeDirectory();
\OwenVoke\LaravelXdg\Facades\Xdg::getHomeDirectory();
```

#### Available methods

| Description                             | Method name                | Return Value |
| :-------------------------------------- | :------------------------- | :----------- |
| Retrieve the XDG home directory.        | `getHomeDirectory()`       | string       |
| Retrieve the XDG home cache directory.  | `getHomeCacheDirectory()`  | string       |
| Retrieve the XDG home config directory. | `getHomeConfigDirectory()` | string       |
| Retrieve the XDG home data directory.   | `getHomeDataDirectory()`   | string       |
| Retrieve the XDG runtime directory.     | `getRuntimeDirectory()`    | string       |
| Retrieve all XDG config directories.    | `getConfigDirectories()`   | Collection   |
| Retrieve all XDG data directories.      | `getDataDirectories()`     | Collection   |

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

```bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email security@voke.dev instead of using the issue tracker.

## Credits

- [Owen Voke][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Treeware

You're free to use this package, but if it makes it to your production environment you are required to buy the world a tree.

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to plant trees. If you support this package and contribute to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees [here][link-treeware-gifting].

Read more about Treeware at [treeware.earth][link-treeware].

[ico-version]: https://img.shields.io/packagist/v/owenvoke/laravel-xdg.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-github-actions]: https://img.shields.io/github/workflow/status/owenvoke/laravel-xdg/Continuous%20Integration.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/241339145/shield
[ico-downloads]: https://img.shields.io/packagist/dt/owenvoke/laravel-xdg.svg?style=flat-square
[ico-treeware-gifting]: https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen?style=flat-square

[link-packagist]: https://packagist.org/packages/owenvoke/laravel-xdg
[link-github-actions]: https://github.com/owenvoke/laravel-xdg/actions
[link-styleci]: https://styleci.io/repos/241339145
[link-downloads]: https://packagist.org/packages/owenvoke/laravel-xdg
[link-treeware]: https://treeware.earth
[link-treeware-gifting]: https://ecologi.com/owenvoke?gift-trees
[link-author]: https://github.com/owenvoke
[link-contributors]: ../../contributors
