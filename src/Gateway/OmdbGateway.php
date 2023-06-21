<?php

namespace App\Gateway;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbGateway
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $apiKey,
    ) { }

    public function getPoster(string $title): ?string
    {
        $url = sprintf('https://www.omdbapi.com/?apikey=%s&t=%s', $this->apiKey, $title);
        $resp = $this->client->request('GET', $url)->toArray();

        return ($resp['Poster'] ?? null) !== 'N/A' ?
            $resp['Poster'] ?? null
            : null;
    }
}