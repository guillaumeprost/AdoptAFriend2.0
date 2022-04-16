<?php

namespace App\Service;

use App\Entity\Animal\Animal;
use App\Entity\Animal\Dog;
use App\Form\Type\Animal\DogType;

class AnimalService
{
    public $mapTypes = [
        Dog::DISCRIMINATOR => DogType::class
    ];

    public function getNewRelatedEntity(string $discriminator): Animal
    {
        return new($this->mapTypes[$discriminator]::RELATED_ENTITY);
    }
}