<?php

namespace App\Entity\Animal;

use App\Repository\Animal\DogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DogRepository::class)]
class Dog extends Animal
{
    const DISCRIMINATOR = 'dog';

    #[ORM\Column(nullable:true)]
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