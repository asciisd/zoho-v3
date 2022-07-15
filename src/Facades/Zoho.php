<?php

namespace Asciisd\Zoho\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Asciisd\Zoho\Zoho
 */
class Zoho extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'zoho-v3';
    }
}
