<?php

namespace App\Form\Type\AdoptionRequest;

use App\Entity\AdoptionRequest\AdoptionRequest;
use App\Entity\AdoptionRequest\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdoptionRequestUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('status', ChoiceType::class, [
                'label' => 'Status',
                'required' => true,
                'choices' => [
                    'Nouvelle' => AdoptionRequest::STATUS_NEW,
                    'En cours' => AdoptionRequest::STATUS_IN_PROGRESS,
                    'Adopté'   => AdoptionRequest::STATUS_ADOPTED
                ]
            ])
            ->add('newComments', CommentType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\AdoptionRequest\AdoptionRequest',
        ]);
    }
}
