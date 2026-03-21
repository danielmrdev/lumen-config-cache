# lumen-config-cache

> **This repository is archived and no longer maintained.**
> Lumen itself is no longer recommended for new projects — use Laravel + Octane instead.
> Feel free to fork if you need to continue using this package.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/orumad/lumen-config-cache.svg?style=flat-square)](https://packagist.org/packages/orumad/lumen-config-cache) [![Total Downloads](https://img.shields.io/packagist/dt/orumad/lumen-config-cache.svg?style=flat-square)](https://packagist.org/packages/orumad/lumen-config-cache) [![License: MIT](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](https://packagist.org/packages/orumad/lumen-config-cache)

Adds the Laravel artisan command `config:cache` to Lumen.

Once installed you can type `php artisan lumen-config:cache` in your console to gets all your Lumen configuration files loaded in the cache, which will increase your Lumen app response times. 


## Installation

This package can be used in Laravel 5.4 or higher with PHP 7.0 or higher.

You can install the package via composer:

```bash
composer require orumad/lumen-config-cache
```

Now register the service provider in `bootstrap/app.php` file:

```php
$app->register(Orumad\ConfigCache\ServiceProviders\ConfigCacheServiceProvider::class);
```

If you want to publish automatically the config file, you must install a package like [lumen-vendor-publish](https://github.com/laravelista/lumen-vendor-publish), which contains a single command that enables you to publish a package config file to the config folder of your Lumen application.

So you can publish the config file like in Laravel:

```bash
php artisan vendor:publish --tag="lumen-config-cache"
```

If you dedice to not install any aditional package, then you can copy the file `vendor/orumad/lumen-config-cache/src/config/config-cache.php` to your app `config` folder.


This is the contents of the published `config/config-cache.php` config file:

```php
return [

    /**
     * The name of the key where the config is stored in cache
     */
    'cache_key' => 'config_cache',

    /**
     * Expiration time for the config in cache
     */
    'cache_expiration_time' => 60*24, // One day

    /**
     * The config files (app, database, queue, etc.) to be cached
     * Add to this array whatever config files you want to load in cache
     */
    'config_files' => [
        'app',
    ],

];
```


You should enable the use of facades in Lumen uncommenting the following line in your `bootstrap/app.php` file:

``` php
// $app->withFacades();
```



## Usage

You can access your config keys with `ConfigCache::get` facade method:

``` php

use Orumad\ConfigCache\Facades\ConfigCache;

...

$api_url = ConfigCache::get('app.API_URL');

```


Also you can force the cached config to be refreshed with `ConfigCache::refresh` facade method:

``` php

use Orumad\ConfigCache\Facades\ConfigCache;

...

ConfigCache::refresh();

```


You can use the `artisan` command `lumen-config:cache` to force the cached configuration to be refreshed too.


**TIP: Add this command to your deployment script to be sure you have the last config cached after deploy your new app release:**

``` bash
php artisan lumen-config:cache
```


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Security

If you discover any security related issues, please email dev@danielmunoz.io instead of using the issue tracker.


## Credits

- [Daniel Muñoz](https://twitter.com/daniel_munoz_)
- [All contributors](../../contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
