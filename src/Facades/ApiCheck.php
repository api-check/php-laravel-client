<?php

namespace ApiCheck\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class ApiCheck extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'apicheck';
    }
}