<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 06/05/2016
 * Time: 12:25
 */

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

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('size', ChoiceType::class, [
            'label' => 'Taille',
            'required' => false,
            'choices' => array_flip(lSize::$types)
        ]);

    }
}
