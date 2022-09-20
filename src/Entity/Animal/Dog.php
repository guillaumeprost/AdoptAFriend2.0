<?php

namespace App\Entity\Animal;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Animal\DogRepository")
 */
class Dog extends Animal
{
    const DISCRIMINATOR = 'dog';

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $size;

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;
        return $this;
    }
}