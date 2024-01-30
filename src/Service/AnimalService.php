<?php

namespace App\Service;

use App\Entity\Animal\Animal;
use App\Entity\Animal\Dog;
use App\Entity\User;
use App\Form\Type\Animal\DogType;

class AnimalService
{
    public array $mapTypes = [
        Dog::DISCRIMINATOR => DogType::class
    ];

    public function getNewRelatedEntity(string $discriminator): Animal
    {
        return new($this->mapTypes[$discriminator]::RELATED_ENTITY);
    }
}