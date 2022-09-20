<?php


namespace App\DataFixtures;


use App\Entity\Animal\Dog;
use App\Utils\Animal\Affinities;
use App\Utils\Animal\Color;
use App\Utils\Animal\Dog\Size;
use App\Utils\Animal\Fur;
use App\Utils\Animal\Sex;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DogFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 50; $i++) {
            $dog = new Dog();
            $dog->setName('Chien '.$i);
            $dog->setSex(array_rand(Sex::$types));
            $dog->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Suspendisse sed tristique justo. Morbi luctus, eros a fringilla fringilla, leo ligula dignissim arcu, at congue ipsum arcu ac ante. 
            Sed suscipit orci quis luctus viverra. 
            Quisque sed porttitor ex, eleifend ultrices orci. Sed ligula enim, facilisis vel elit a, porttitor congue ligula. 
            Nunc in leo at ligula bibendum pulvinar. Sed convallis porttitor tristique. 
            Phasellus nisi erat, finibus at odio ac, euismod vehicula mi.'
            );
            $dog->setWeight(mt_rand(10, 60));
            $images = [];
            for ($j = 1; $j < mt_rand(1, 3); $j++) {
                $images[] = str_replace('%d', mt_rand(1, 10), 'chien%d.jpg');
            }
            $dog->setImages($images);
            $dog->setFur(array_rand(Fur::$types));
            $dog->setColor(array_rand(Color::$types));
            $dog->setBirthDate(new \DateTime());

            $dog->setVaccination( (bool)random_int(0, 1));
            $dog->setSterilized( (bool)random_int(0, 1));
            $dog->setDewormed( (bool)random_int(0, 1));

            $dog->setChildAffinities(array_rand(Affinities::$types));
            $dog->setDogsAffinities(array_rand(Affinities::$types));
            $dog->setCatsAffinities(array_rand(Affinities::$types));

            $dog->setPrice(mt_rand(100, 500));

            $dog->setSize(array_rand(Size::$types));
            $manager->persist($dog);
        }
        $manager->flush();
    }
}