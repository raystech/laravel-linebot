<?php

namespace raystech\laravel-linebot\Facades;

use Illuminate\Support\Facades\Facade;

class laravel-linebot extends Facade
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
