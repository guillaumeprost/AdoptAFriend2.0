<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 14/08/2016
 * Time: 11:30
 */

namespace App\Form\Type\Search;
use App\Entity\Animal\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

/**
 * Class AnimalType
 * @package App\Form\Type\Search
 */
class AnimalType extends AbstractType
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
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'required' => true,
                'choices' => Animal::DISCRIMINATORS,
                'multiple' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'date_class' => 'App\Entity\Animal\Animal'
        ]);
    }
}
