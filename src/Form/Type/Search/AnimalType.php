<?php

namespace App\Form\Type\Search;

use App\Entity\Animal\Animal;
use App\Model\SearchAnimal;
use App\Utils\Animal\Affinities;
use App\Utils\Animal\Color;
use App\Utils\Animal\Fur;
use App\Utils\Animal\Sex;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            /*->add('type', ChoiceType::class, [
                'label' => 'Type',
                'required' => true,
                'choices' => Animal::DISCRIMINATORS,
                'multiple' => false
            ])*/
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => false,
            ])
            ->add('sex', ChoiceType::class, [
                'label' => 'Sexe',
                'required' => false,
                'choices' => array_flip(Sex::$choices)
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
            ->add('childAffinities', EnumType::class, [
                'label' => 'Affinité avec les enfants',
                'class' => Affinities::class,
                'required' => false
            ])
            ->add('catsAffinities', EnumType::class, [
                'label' => 'Affinité avec les chats',
                'class' => Affinities::class,
                'required' => false,
            ])
            ->add('dogsAffinities', EnumType::class, [
                'label' => 'Affinité avec les chiens',
                'required' => false,
                'class' => Affinities::class,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchAnimal::class
        ]);
    }
}
