<?php

namespace Danielmrdev\ConfigCache;

use Illuminate\Support\Facades\Cache;

class ConfigCache
{
    private $cacheKey;

    /**
     * Creates the instance and stores the config data
     * (if this is not in chache yet)
     * @param Array $config The app config data
     */
    public function __construct(array $config, $cacheKey = 'config_cache', $expirationTime = 60*24)
    {
        $this->cacheKey = $cacheKey;

        Cache::add($this->cacheKey, $config, $expirationTime);
    }

    /**
     * Returns a key from the cached configuration
     * @param  string $key
     * @return any
     */
    public function get($key)
    {
        $config = Cache::get($this->cacheKey);

        return $config[$key];
    }

    /**
     * Refresh (reload) the configuration in the cache
     */
    public function refresh()
    {
        Cache::forget($this->cacheKey);
    }
}
