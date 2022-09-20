<?php

namespace App\Form\Type\Animal;

use App\Entity\Animal\Dog;
use App\Utils\Animal\Dog\Size;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class DogType
 * @package App\Form\Type\Animal
 */
class DogType extends AnimalType
{
    const RELATED_ENTITY = Dog::class;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('size', ChoiceType::class, [
            'label' => 'Taille',
            'required' => false,
            'choices' => array_flip(Size::$types)
        ]);
    }
}
