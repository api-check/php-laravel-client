<?php

namespace ApiCheck\Laravel;

use ApiCheck\Laravel\countries\Belgium;
use ApiCheck\Laravel\countries\Luxembourg;
use ApiCheck\Laravel\countries\Netherlands;

class Country
{
    /*
    |--------------------------------------------------------------------------
    | The Netherlands
    |--------------------------------------------------------------------------
    */
    public function netherlands(): Netherlands
    {
        return new Netherlands;
    }

    /*
    |--------------------------------------------------------------------------
    | Belgium
    |--------------------------------------------------------------------------
    */
    public function belgium(): Belgium
    {
        return new Belgium;
    }

    /*
    |--------------------------------------------------------------------------
    | Luxembourg
    |--------------------------------------------------------------------------
    */
    public function luxembourg(): Luxembourg
    {
        return new Luxembourg;
    }
}
