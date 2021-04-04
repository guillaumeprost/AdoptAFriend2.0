<?php

namespace App\Trait\Entity;

trait AffinitiesTrait
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $dogsAffinities;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $catsAffinities;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $childAffinities;

    /**
     * @return string
     */
    public function getDogsAffinities(): string
    {
        return $this->dogsAffinities;
    }

    /**
     * @param string $dogsAffinities
     */
    public function setDogsAffinities(string $dogsAffinities): self
    {
        $this->dogsAffinities = $dogsAffinities;
        return $this;
    }

    /**
     * @return string
     */
    public function getCatsAffinities(): string
    {
        return $this->catsAffinities;
    }

    /**
     * @param string $catsAffinities
     */
    public function setCatsAffinities(string $catsAffinities): self
    {
        $this->catsAffinities = $catsAffinities;
        return $this;
    }

    /**
     * @return string
     */
    public function getChildAffinities(): string
    {
        return $this->childAffinities;
    }

    /**
     * @param string $childAffinities
     */
    public function setChildAffinities(string $childAffinities): self
    {
        $this->childAffinities = $childAffinities;
        return $this;
    }
}