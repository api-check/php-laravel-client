<?php

namespace ApiCheck\Laravel;

use stdClass;
use Illuminate\Config\Repository;
use ApiCheck\Api\ApiClient;

class ApiClientAdapter
{
    protected Repository $config;

    protected ApiClient $client;

    /**
     * ApiWrapper constructor.
     *
     * @param Repository $config
     * @param ApiClient $client
     *
     * @throws ApiException
     */
    public function __construct(Repository $config, ApiClient $client)
    {
        $this->config = $config;
        $this->client = $client;

        $this->setApiKey(
            $this->config->get('apicheck.api_key')
        );
    }

    /**
     * Ste the custom API endpoint.
     *
     * @param string $url
     */
    public function setApiEndpoint(string $url): void
    {
        $this->client->setApiEndpoint($url);
    }

    /**
     * Get the API endpoint.
     *
     * @return string
     */
    public function getApiEndpoint(): string
    {
        return $this->client->getApiEndpoint();
    }

    /**
     * Set the API key.
     *
     * @param $apiKey
     * @return void
     * @throws ApiException
     */
    public function setApiKey(string $apiKey): void
    {
        $this->client->setApiKey($apiKey);
    }

    /**
     * Wrapper for Lookup endpoint.
     *
     * @param string $country
     * @param array $query
     * @return stdClass
     */
    public function lookup($country, $query)
    {
        return $this->client->lookup($country, $query);
    }

    /**
     * Wrapper for Search endpoint.
     *
     * @param string $country
     * @param string $type
     * @param array $query
     * @return stdClass
     */
    public function search($country, $type, $query)
    {
        return $this->client->lookup($country, $type, $query);
    }
}
