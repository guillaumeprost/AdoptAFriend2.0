<?php

namespace App\Form\Type\Animal;

class CatType extends AnimalType
{
    public function getBlockPrefix(): string
    {
        return 'cat';
    }
}
