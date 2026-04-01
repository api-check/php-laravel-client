<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | Your ApiCheck API key. Get one at:
    | https://app.apicheck.nl/authentication/register
    |
    */

    'api_key' => env('APICHECK_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Referer
    |--------------------------------------------------------------------------
    |
    | Optional referer header sent with every request.
    | Required when your API key has "Allowed Hosts" configured.
    |
    | Example: 'referer' => env('APICHECK_REFERER', 'https://myapp.com'),
    |
    */

    'referer' => env('APICHECK_REFERER'),

];
