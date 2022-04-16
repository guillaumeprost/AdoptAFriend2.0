<?php

namespace App\Entity\Animal;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\Animal\DogRepository")
 */
class Dog extends Animal
{
    const DISCRIMINATOR = 'dog';

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $size;

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     * @return Dog
     */
    public function setSize(string $size): self
    {
        $this->size = $size;
        return $this;
    }
}