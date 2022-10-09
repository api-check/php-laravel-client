<?php

namespace ApiCheck\Laravel;

use Illuminate\Contracts\Container\Container;

class Manager
{
    protected Container $app;

    /**
     * ApiCheckManager constructor.
     *
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Get the ApiCheck API adapter instance.
     *
     * @return ApiClientAdapter
     */
    public function api(): ApiClientAdapter
    {
        return $this->app['apicheck.api'];
    }
}
