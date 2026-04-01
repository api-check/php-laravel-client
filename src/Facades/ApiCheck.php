<?php

namespace ApiCheck\Laravel\Facades;

use ApiCheck\Api\ApiClient;
use Illuminate\Support\Facades\Facade;

/**
 * @see ApiClient
 *
 * @method static ApiClient setApiKey(string $apiKey)
 * @method static ApiClient setReferer(string $referer)
 * @method static string getApiVersion()
 * @method static \stdClass lookup(string $country, array $query = [])
 * @method static \stdClass getNumberAdditions(string $country, string $postalcode, string|int $number)
 * @method static \stdClass search(string $country, string $type, array $query = [])
 * @method static \stdClass globalSearch(string $country, string $query, array $options = [])
 * @method static \stdClass searchLocality(string $country, string $name, array $options = [])
 * @method static \stdClass searchMunicipality(string $country, string $name, array $options = [])
 * @method static \stdClass searchAddress(string $country, array $params = [])
 * @method static \stdClass getSupportedSearchCountries()
 * @method static \stdClass verifyEmail(string $email)
 * @method static \stdClass verifyPhone(string $number)
 */
class ApiCheck extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'apicheck';
    }
}
