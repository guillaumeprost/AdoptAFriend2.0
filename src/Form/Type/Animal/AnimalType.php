<?php

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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AnimalType extends AbstractType
{
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
                'choices' => array_flip(Sex::$choices)
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => [
                    'rows' => 10,
                    'placeholder' => 'Décris ton animal...',
                ],
            ])
            ->add('images', FileType::class, [
                'label' => 'Images',
                'multiple' => true,
                'required' => false
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
                'choices' => Affinities::cases()
            ])
            ->add('catsAffinities', ChoiceType::class, [
                'label' => 'Affinité avec les chats',
                'required' => false,
                'choices' => Affinities::cases()
            ])
            ->add('dogsAffinities', ChoiceType::class, [
                'label' => 'Affinité avec les chiens',
                'required' => false,
                'choices' => Affinities::cases()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Animal::class
        ]);
    }
}
