<?php

namespace App\Entity\Animal;

use App\Repository\Animal\DogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DogRepository::class)]
class Dog extends Animal
{
    const DISCRIMINATOR = 'dog';
    const LABEL = 'Chien';

    #[ORM\Column(nullable:true)]
    private ?string $size;

    public function getType(): string
    {
        return self::DISCRIMINATOR;
    }

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