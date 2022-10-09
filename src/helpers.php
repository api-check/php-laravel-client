<?php

use ApiCheck\Laravel\ApiClientAdapter;

if ( ! function_exists('apicheck')) {

    /**
     * Helper function to access the ApiCheck api instance.
     *
     * @return ApiClientAdapter
     */
    function apicheck(): ApiClientAdapter
    {
        return resolve('apicheck.api');
    }
}