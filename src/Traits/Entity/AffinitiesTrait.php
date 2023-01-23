<?php

namespace App\Traits\Entity;

use Doctrine\ORM\Mapping\Column;

trait AffinitiesTrait
{
    #[Column(nullable:true)]
    private string $dogsAffinities;

    #[Column(nullable:true)]
    private string $catsAffinities;

    #[Column(nullable:true)]
    private string $childAffinities;

    public function getDogsAffinities(): ?string
    {
        return $this->dogsAffinities;
    }

    public function setDogsAffinities(string $dogsAffinities): self
    {
        $this->dogsAffinities = $dogsAffinities;
        return $this;
    }

    public function getCatsAffinities(): ?string
    {
        return $this->catsAffinities;
    }

    public function setCatsAffinities(string $catsAffinities): self
    {
        $this->catsAffinities = $catsAffinities;
        return $this;
    }

    public function getChildAffinities(): ?string
    {
        return $this->childAffinities;
    }

    public function setChildAffinities(string $childAffinities): self
    {
        $this->childAffinities = $childAffinities;
        return $this;
    }
}