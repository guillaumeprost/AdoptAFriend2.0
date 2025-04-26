<?php

namespace App\Form\Type;

use App\Entity\Organisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false
            ])
            ->add('color', ColorType::class, [
                'label' => 'Couleur',
                'required' => false
            ])
            ->add('signature', TextareaType::class, [
                'label' => 'Signature',
                'required' => false
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse ',
                'required' => false
            ])
            ->add('logo', FileType::class, [
                'label' => 'Logo',
                'multiple' => false,
                'required' => false
            ])
            ->add('images', FileType::class, [
                'label' => 'Images',
                'multiple' => true,
                'required' => false
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organisation::class
        ]);
    }
}
