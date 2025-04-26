<?php

namespace App\Traits\Entity;

use App\Utils\Animal\Affinities;
use Doctrine\ORM\Mapping as ORM;

trait AffinitiesTrait
{
    #[ORM\Column(nullable:true)]
    private Affinities $dogsAffinities;

    #[ORM\Column(nullable:true)]
    private Affinities $catsAffinities;

    #[ORM\Column(nullable:true)]
    private Affinities $childAffinities;

    public function getDogsAffinities(): ?Affinities
    {
        return $this->dogsAffinities;
    }

    public function setDogsAffinities(Affinities $dogsAffinities): self
    {
        $this->dogsAffinities = $dogsAffinities;
        return $this;
    }

    public function getCatsAffinities(): ?Affinities
    {
        return $this->catsAffinities;
    }

    public function setCatsAffinities(Affinities $catsAffinities): self
    {
        $this->catsAffinities = $catsAffinities;
        return $this;
    }

    public function getChildAffinities(): ?Affinities
    {
        return $this->childAffinities;
    }

    public function setChildAffinities(Affinities $childAffinities): self
    {
        $this->childAffinities = $childAffinities;
        return $this;
    }
}
