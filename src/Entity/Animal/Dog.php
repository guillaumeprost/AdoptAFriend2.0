<?php

namespace App\Entity\Animal;

use App\Repository\Animal\DogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DogRepository::class)]
class Dog extends Animal
{
    const DISCRIMINATOR = 'dog';
    const LABEL = 'Chien';

    #[ORM\Column(nullable: true)]
    public private(set) ?string $size = null;

    public function getType(): string
    {
        return self::DISCRIMINATOR;
    }

    public function setSize(?string $size): static
    {
        $this->size = $size;
        return $this;
    }
}
