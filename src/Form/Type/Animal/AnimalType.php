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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
            ->add('forAdoption', CheckboxType::class, [
                'label' => 'En recherche d\'adoption',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-switch'
                ]
            ])
            ->add('forFoster', CheckboxType::class, [
                'label' => 'En recherche de famille d\'acceuil',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-switch'
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true
            ])
            ->add('sex', ChoiceType::class, [
                'label' => 'Sexe',
                'required' => false,
                'choices' => array_flip(Sex::$choices),
                'placeholder' => 'Sélectionne le sexe',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => [
                    'rows' => 10,
                    'placeholder' => 'Âge, caractère, entente, habitudes…',
                ],
            ])
            ->add('images', FileType::class, [
                'label' => 'Images',
                'multiple' => true,
                'required' => false,
                'help' => 'JPG/PNG/WebP conseillés. Ajoute plusieurs photos nettes (portrait + entier).',
                'help_attr' => ['class' => 'form-text text-muted']
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
                'attr' => ['placeholder' => 'En kg']
            ])
            ->add('fur', ChoiceType::class, [
                'label' => 'Pelage',
                'required' => false,
                'choices' => array_flip(Fur::$types),
                'placeholder' => 'Non précisé'
            ])
            ->add('color', ChoiceType::class, [
                'label' => 'Couleur',
                'required' => false,
                'choices' => Color::$types,
                'placeholder' => 'Non précisée'
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
                'required' => false
            ])
            ->add('childAffinities', ChoiceType::class, [
                'label' => 'Affinité avec les enfants',
                'required' => false,
                'choices' => Affinities::cases(),
                'placeholder' => 'Non précisé'
            ])
            ->add('catsAffinities', ChoiceType::class, [
                'label' => 'Affinité avec les chats',
                'required' => false,
                'choices' => Affinities::cases(),
                'placeholder' => 'Non précisé'
            ])
            ->add('dogsAffinities', ChoiceType::class, [
                'label' => 'Affinité avec les chiens',
                'required' => false,
                'choices' => Affinities::cases(),
                'placeholder' => 'Non précisé'
            ])
            // Adresse (Address embeddable)
            ->add('addressLine1', TextType::class, [
                'label' => 'Adresse',
                'property_path' => 'address.line1',
                'required' => true,
                'attr' => [
                    'autocomplete' => 'address-line1',
                    'placeholder' => 'Numéro et rue',
                ]
            ])
            ->add('addressLine2', TextType::class, [
                'label' => 'Complément',
                'property_path' => 'address.line2',
                'required' => false,
                'attr' => ['placeholder' => 'Bâtiment, étage, interphone…']
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code postal',
                'property_path' => 'address.postalCode',
                'required' => true,
                'attr' => [
                    'inputmode' => 'numeric',
                    'placeholder' => 'Ex. 01000',
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'property_path' => 'address.city',
                'required' => true,
                'attr' => ['placeholder' => 'Ex. Lyon']
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'property_path' => 'address.country',
                'required' => true,
                'empty_data' => 'FR',
                'attr' => ['placeholder' => 'FR']
            ])
            // Coordonnées (GeoPoint embeddable)
            ->add('geoLat', HiddenType::class, [
                'property_path' => 'location.lat',
                'required' => false,
            ])
            ->add('geoLng', HiddenType::class, [
                'property_path' => 'location.lng',
                'required' => false,
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
