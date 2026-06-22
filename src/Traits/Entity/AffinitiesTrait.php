<?php

namespace App\Traits\Entity;

use App\Utils\Animal\Affinities;
use Doctrine\ORM\Mapping as ORM;

trait AffinitiesTrait
{
    #[ORM\Column(nullable: true)]
    public private(set) ?Affinities $dogsAffinities = null;

    #[ORM\Column(nullable: true)]
    public private(set) ?Affinities $catsAffinities = null;

    #[ORM\Column(nullable: true)]
    public private(set) ?Affinities $childAffinities = null;

    public function setDogsAffinities(?Affinities $dogsAffinities): static
    {
        $this->dogsAffinities = $dogsAffinities;
        return $this;
    }

    public function setCatsAffinities(?Affinities $catsAffinities): static
    {
        $this->catsAffinities = $catsAffinities;
        return $this;
    }

    public function setChildAffinities(?Affinities $childAffinities): static
    {
        $this->childAffinities = $childAffinities;
        return $this;
    }
}
