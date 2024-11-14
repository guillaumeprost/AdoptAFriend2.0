<?php

namespace App\Form\Type\Animal;

use App\Entity\Animal\Cat;

class CatType extends AnimalType
{
    const RELATED_ENTITY = Cat::class;

    public function getBlockPrefix(): string
    {
        return 'cat';
    }
}
