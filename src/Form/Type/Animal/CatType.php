<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 06/05/2016
 * Time: 12:25
 */

namespace AppBundle\Form\Type\Animal;

class CatType extends AnimalType
{
    public function getBlockPrefix()
    {
        return 'cat';
    }
}
