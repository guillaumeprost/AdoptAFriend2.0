<?php

namespace App\Entity\Animal;

use App\Repository\Animal\CatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatRepository::class)]
class Cat extends Animal
{
    const DISCRIMINATOR = 'cat';
    const LABEL = 'Chat';

    public function getType(): string
    {
        return self::DISCRIMINATOR;
    }
}