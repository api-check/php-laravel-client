<?php

namespace ApiCheck\Laravel\Exceptions;

use InvalidArgumentException;

class MissingApiKeyException extends InvalidArgumentException
{
    /**
     * Create a new exception for a missing API key.
     */
    public static function create(): self
    {
        return new self(
            'No ApiCheck API key configured. Set APICHECK_API_KEY in your .env file '
            . 'or configure "apicheck.api_key".'
        );
    }
}
