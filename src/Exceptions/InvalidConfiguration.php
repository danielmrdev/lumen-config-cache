<?php

namespace Danielmrdev\ConfigCache\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function configFilesNotSpecified()
    {
        return new static('You must specify at least one config file in the config-cache configuration.');
    }
}
