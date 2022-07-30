<?php

namespace ApiCheck\Laravel;

use GuzzleHttp\Client;
use Psr\Http\Message\StreamInterface;

class ApiCheck
{
    protected $url = 'api.apicheck.nl';

    protected $client;

    public function lookup(): Country
    {
        return new Country();
    }

    public function query(array $search): StreamInterface
    {
        return $this->client()->get("{$this->url}?{$this->queryParameters($search)}")->getBody();
    }

    protected function queryParameters(array $search): string
    {
        return http_build_query(array_merge($this->getOptions(), $search));
    }

    public function getOptions(): array
    {
        return [
            'APPID' => config('apicheck.key'),
        ];
    }

    protected function client(): Client
    {
        return $this->client ?? new Client();
    }

    public function using(Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
