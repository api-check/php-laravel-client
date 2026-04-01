# ApiCheck Laravel Client

A thin Laravel wrapper for the [ApiCheck PHP Client](https://github.com/api-check/php-client).

ApiCheck helps you validate customer data - addresses, emails, and phone numbers.

## Requirements

- PHP 8.1+
- Laravel 9.0+ | 10.0+ | 11.0+
- An ApiCheck API key ([get one here](https://app.apicheck.nl/authentication/register))

## Installation

```bash
composer require api-check/php-laravel-client
```

The service provider and facade are auto-discovered by Laravel.

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=apicheck-config
```

Add to your `.env`:

```env
APICHECK_API_KEY=your-api-key-here

# Optional - required if your API key has "Allowed Hosts" configured
APICHECK_REFERER=https://yourdomain.com
```

## Usage

### Via Facade

```php
use ApiCheck\Laravel\Facades\ApiCheck;

// Lookup an address (NL, LU)
$address = ApiCheck::lookup('nl', [
    'postalcode' => '2513AA',
    'number' => 1,
]);

// Get available number additions
$additions = ApiCheck::getNumberAdditions('nl', '2513AA', 1);

// Search for addresses (18 European countries)
$results = ApiCheck::search('be', 'city', ['name' => 'Brussels']);

// Global search
$results = ApiCheck::globalSearch('nl', 'amsterdam', ['limit' => 10]);

// Verify email
$emailResult = ApiCheck::verifyEmail('test@example.com');
// Returns: disposable_email (bool), greylisted (bool), status ("valid"|"invalid"|"unknown")

// Verify phone
$phoneResult = ApiCheck::verifyPhone('+31612345678');
// Returns: valid (bool), country_code, area_code, international_formatted, etc.
```

### Via Helper Function

```php
$address = apicheck()->lookup('nl', ['postalcode' => '2513AA', 'number' => 1]);
```

### Via Dependency Injection

```php
use ApiCheck\Api\ApiClient;

public function __construct(ApiClient $apiCheck)
{
    $this->apiCheck = $apiCheck;
}

public function index()
{
    $address = $this->apiCheck->lookup('nl', ['postalcode' => '2513AA', 'number' => 1]);
}
```

## Available Methods

All methods from [api-check/php-client](https://github.com/api-check/php-client) are available:

### Lookup API (NL, LU)
- `lookup($country, $query)` - Look up address by postal code + house number
- `getNumberAdditions($country, $postalcode, $number)` - Get available number additions (e.g., "A", "1-3")

### Search API (18 European countries)
- `search($country, $type, $query)` - Search by type: `city`, `street`, `postalcode`, `address`, `locality`, `municipality`
- `globalSearch($country, $query, $options)` - Global search across all scopes
- `searchLocality($country, $name, $options)` - Search localities (deelgemeenten, primarily BE)
- `searchMunicipality($country, $name, $options)` - Search municipalities (gemeenten, primarily BE)
- `searchAddress($country, $params)` - Resolve full address from IDs returned by other searches
- `getSupportedSearchCountries()` - List supported countries

### Verify API
- `verifyEmail($email)` - Validate email address (disposable, greylisted, valid/invalid/unknown)
- `verifyPhone($number)` - Validate phone number with formatting and type info

## Supported Countries

### Lookup API
- Netherlands (nl)
- Luxembourg (lu)

### Search & Verify APIs
18 European countries: nl, be, lu, fr, de, cz, fi, it, no, pl, pt, ro, es, ch, at, dk, gb, se

## Exception Handling

```php
use ApiCheck\Api\Exceptions\NotFoundException;
use ApiCheck\Api\Exceptions\ValidationException;
use ApiCheck\Api\Exceptions\UnsupportedCountryException;
use ApiCheck\Api\Exceptions\ApiException;

try {
    $address = ApiCheck::lookup('nl', ['postalcode' => '2513AA', 'number' => 1]);
} catch (NotFoundException $e) {
    // No results found
} catch (ValidationException $e) {
    // Invalid input
} catch (UnsupportedCountryException $e) {
    // Country not supported for this endpoint
} catch (ApiException $e) {
    // General API error
}
```

## License

[MIT](https://choosealicense.com/licenses/mit/)

## Support

- Website: [apicheck.nl](https://www.apicheck.nl)
- Email: support@apicheck.nl
- Documentation: [apicheck.nl/documentation](https://apicheck.nl/documentation)
