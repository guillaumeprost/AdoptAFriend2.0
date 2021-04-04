<?php


namespace App\Form\Type;


use App\Entity\Offer;
use App\Form\Type\Animal\AnimalType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
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
                'label' => "Titre de l\'annonce"
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description de l\'annonce"
            ])
            ->add('emails', CollectionType::class, [
                // each entry in the array will be an "email" field
                'entry_type' => AnimalType::class,
                // these options are passed to each "email" type
                'entry_options' => [
//                    'attr' => ['class' => 'email-box'],
                ],
            ]);

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'date_class' => Offer::class
        ]);
    }
}