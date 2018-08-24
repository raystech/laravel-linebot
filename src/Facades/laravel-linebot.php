<?php

namespace Raystech\Linebot\Facades;

use Illuminate\Support\Facades\Facade;

class Linebot extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-linebot';
    }
}
