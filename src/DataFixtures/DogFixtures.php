<?php

namespace App\DataFixtures;

use App\Entity\Animal\Dog;
use App\Entity\Organisation;
use App\Utils\Animal\Affinities;
use App\Utils\Animal\Color;
use App\Utils\Animal\Dog\Size;
use App\Utils\Animal\Fur;
use App\Utils\Animal\Sex;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ValueObject\Address;
use App\Entity\ValueObject\GeoPoint;

class DogFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $organisations = $manager->getRepository(Organisation::class)->findAll();

        // Pool d'adresses FR (adresse + CP/ville/pays + coordonnées approx.)
        $places = [
            ['line1' => '12 Rue de la République', 'postal' => '69002', 'city' => 'Lyon',        'country' => 'FR', 'lat' => 45.761, 'lng' => 4.835],
            ['line1' => '5 Avenue des Frères Lumière','postal' => '69008','city' => 'Lyon',     'country' => 'FR', 'lat' => 45.736, 'lng' => 4.872],
            ['line1' => '25 Quai Saint-Vincent',      'postal' => '69001', 'city' => 'Lyon',    'country' => 'FR', 'lat' => 45.770, 'lng' => 4.824],
            ['line1' => '14 Rue de Charonne',         'postal' => '75011', 'city' => 'Paris',   'country' => 'FR', 'lat' => 48.853, 'lng' => 2.379],
            ['line1' => '3 Place de la Bourse',       'postal' => '33000', 'city' => 'Bordeaux','country' => 'FR', 'lat' => 44.841, 'lng' => -0.571],
            ['line1' => '2 Rue Sainte-Catherine',     'postal' => '33000', 'city' => 'Bordeaux','country' => 'FR', 'lat' => 44.838, 'lng' => -0.574],
            ['line1' => '1 Place Bellecour',          'postal' => '69002', 'city' => 'Lyon',    'country' => 'FR', 'lat' => 45.757, 'lng' => 4.832],
            ['line1' => '10 Rue de la République',    'postal' => '13001', 'city' => 'Marseille','country' => 'FR','lat' => 43.298, 'lng' => 5.376],
            ['line1' => '8 Rue Sainte',               'postal' => '13001', 'city' => 'Marseille','country' => 'FR','lat' => 43.288, 'lng' => 5.372],
            ['line1' => '4 Rue du Taur',              'postal' => '31000', 'city' => 'Toulouse','country' => 'FR', 'lat' => 43.604, 'lng' => 1.443],
            ['line1' => '2 Place du Parlement',       'postal' => '35000', 'city' => 'Rennes',  'country' => 'FR', 'lat' => 48.112, 'lng' => -1.679],
            ['line1' => '6 Place Kléber',             'postal' => '67000', 'city' => 'Strasbourg','country' => 'FR','lat' => 48.583,'lng' => 7.745],
        ];

        for ($i = 1; $i < 50; $i++) {
            $dog = new Dog();
            $dog->setForAdoption((bool)random_int(0, 1));
            $dog->setForFoster((bool)random_int(0, 1));
            $dog->setName('Chien ' . $i);
            $dog->setSex(array_rand(Sex::$choices));
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
            $dog->setBirthDate((new \DateTime())->modify('-' . random_int(1, 70) . ' months'));

            $dog->setVaccination((bool)random_int(0, 1));
            $dog->setSterilized((bool)random_int(0, 1));
            $dog->setDewormed((bool)random_int(0, 1));

            // Adresse & coordonnées aléatoires
            $p = $places[array_rand($places)];
            $addr = new Address();
            $addr->line1 = $p['line1'];
            $addr->postalCode = $p['postal'];
            $addr->city = $p['city'];
            $addr->country = $p['country'];
            $dog->setAddress($addr);

            $loc = new GeoPoint();
            // Légère variation pour éviter les marqueurs exacts en doublon
            $loc->lat = $p['lat'] + (mt_rand(-50, 50) / 10000); // +/- 0.005°
            $loc->lng = $p['lng'] + (mt_rand(-50, 50) / 10000);
            $dog->setLocation($loc);

            $dog->setChildAffinities(Affinities::cases()[array_rand(Affinities::cases())]);
            $dog->setDogsAffinities(Affinities::cases()[array_rand(Affinities::cases())]);
            $dog->setCatsAffinities(Affinities::cases()[array_rand(Affinities::cases())]);

            $dog->setPrice(mt_rand(100, 500));

            $dog->setManager($this->getReference(UserFixtures::USER_REFERENCE . random_int(1, 3)));

            $dog->setOrganisation($organisations[array_rand($organisations)]);

            $dog->setSize(array_rand(Size::$types));
            $manager->persist($dog);
        }
        $manager->flush();
    }

    public function getOrder(): int
    {
        return 3;
    }
}
