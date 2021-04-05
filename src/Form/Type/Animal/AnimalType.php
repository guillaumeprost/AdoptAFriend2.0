<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 06/05/2016
 * Time: 12:07
 */

namespace App\Form\Type\Animal;

use App\Entity\Animal\Animal;
use App\Utils\Animal\Affinities;
use App\Utils\Animal\Color;
use App\Utils\Animal\Fur;
use App\Utils\Animal\Sex;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AnimalType
 * @package App\Form\Type\Animal
 */
abstract class AnimalType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true
            ])
            ->add('sex', ChoiceType::class, [
                'label' => 'Sexe',
                'required' => false,
                'choices' => array_flip(Sex::$types)
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true
            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'choice',
                'required' => false,
                'format' => 'dd M yyyy',
                'label' => 'Date de naissance'
            ])
            ->add('weight', NumberType::class, [
                'label' => 'Poids',
                'required' => false,
            ])
            ->add('fur', ChoiceType::class, [
                'label' => 'Pelage',
                'required' => false,
                'choices' => array_flip(Fur::$types)
            ])
            ->add('color', ChoiceType::class, [
                'label' => 'Couleur',
                'required' => false,
                'choices' => Color::$types
            ])
            ->add('vaccination', CheckboxType::class, [
                'label' => 'Vacciné ?',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-switch'
                ]
            ])
            ->add('sterilized', CheckboxType::class, [
                'label' => 'Stérilisé ?',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-switch'
                ]
            ])
            ->add('dewormed', CheckboxType::class, [
                'label' => 'Vermifugé ?',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-switch'
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Compensation demandée',
                'required' => false,
            ])
            ->add('childAffinities', ChoiceType::class, [
                'label' => 'Affinité avec les enfants',
                'required' => false,
                'choices' => array_flip(Affinities::$types)
            ])
            ->add('catsAffinities', ChoiceType::class, [
                'label' => 'Affinité avec les chats',
                'required' => false,
                'choices' => array_flip(Affinities::$types)
            ])
            ->add('dogsAffinities', ChoiceType::class, [
                'label' => 'Affinité avec les chiens',
                'required' => false,
                'choices' => array_flip(Affinities::$types)
            ])

            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'date_class' => Animal::class
        ]);
    }
}
