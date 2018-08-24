<?php

namespace Raystech\LINEBot\Facades;

use Illuminate\Support\Facades\Facade;

class LINEBot extends Facade
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
