<?php

namespace Danielmrdev\ConfigCache\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Danielmrdev\ConfigCache\ConfigCache
 */
class ConfigCache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'lumen-config-cache';
    }
}
