<?php

// src/Service/Geocoder.php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class GeocoderService
{
    public function __construct(private HttpClientInterface $http) {}

    public function geocode(string $query): ?array
    {
        $resp = $this->http->request('GET', 'https://nominatim.openstreetmap.org/search', [
            'query' => ['q' => $query, 'format' => 'json', 'limit' => 1],
            'headers' => ['User-Agent' => 'AdoptAFriend/1.0 (contact@ton-domaine.fr)'],
            'timeout' => 8,
        ]);
        $data = $resp->toArray(false);
        if (!$data || empty($data[0]['lat']) || empty($data[0]['lon'])) return null;
        return ['lat' => (float)$data[0]['lat'], 'lng' => (float)$data[0]['lon']];
    }
}