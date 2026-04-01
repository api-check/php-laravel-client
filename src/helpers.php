<?php

use ApiCheck\Api\ApiClient;

if (! function_exists('apicheck')) {
    /**
     * Get the ApiCheck API client instance.
     *
     * @return ApiClient
     */
    function apicheck(): ApiClient
    {
        return app('apicheck');
    }
}
