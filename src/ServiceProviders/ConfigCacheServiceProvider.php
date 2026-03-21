<?php

namespace Danielmrdev\ConfigCache\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;
use Danielmrdev\ConfigCache\ConfigCache;
use Danielmrdev\ConfigCache\Exceptions\InvalidConfiguration;

class ConfigCacheServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Config file publish
        $configPath = app()->basePath() . '/config/config-cache.php';
        $this->publishes([
            __DIR__.'/../config/config-cache.php' => $configPath,
        ], 'lumen-config-cache');

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Danielmrdev\ConfigCache\Commands\ConfigCacheCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config-cache.php', 'config-cache');

        $config = config('config-cache');

        $this->app->bind(ConfigCache::class, function () use ($config) {
            // Checks if configuration is valid
            $this->guardAgainstInvalidConfiguration($config);

            // Gets all the config files in one array ("dot" notation)
            $configs_array = [];
            foreach ($config['config_files'] as $configFile) {
                $configs_array[$configFile] = config($configFile);
            }

            return new ConfigCache(Arr::dot($configs_array), $config['cache_key'], $config['cache_expiration_time']);
        });

        $this->app->alias(ConfigCache::class, 'lumen-config-cache');
    }

    /**
     * Checks if the config is valid
     * @param  array|null $config the package configuration
     * @return throws an InvalidConfiguration exception or null
     * @see  \Me\MyPackage\Exceptions\InvalidConfiguration
     */
    protected function guardAgainstInvalidConfiguration(array $config = null)
    {
        if (empty($config['config_files'])) {
            throw InvalidConfiguration::configFilesNotSpecified();
        }
    }
}
