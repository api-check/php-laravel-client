<?php

namespace ApiCheck\Laravel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ApiCheck\Laravel
 */
class ApiCheckFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'apicheck';
    }
}
