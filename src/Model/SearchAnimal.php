<?php

namespace App\Model;

use App\Entity\Organisation;
use App\Utils\Animal\Affinities;

class SearchAnimal
{
    public ?string $type = null;

    public ?string $name = null;

    public ?string $sex = null;

    public ?float $weight = null;

    public ?string $fur = null;

    public ?string $color = null;

    public ?bool $vaccination = null;

    public ?bool $sterilized = null;

    public ?bool $dewormed = null;

    public ?string $address = null;
    public ?float $geoLat = null;
    public ?float $geoLng = null;
    public ?int $radiusKm = 50;

    public ?Organisation $organisation = null;

    public ?Affinities $dogsAffinities = null;

    public ?Affinities $catsAffinities = null;

    public ?Affinities $childAffinities = null;
}
