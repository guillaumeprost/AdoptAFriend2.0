<?php

namespace App\DataFixtures;

use App\Entity\Organisation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrganisationFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 10; $i++) {
            $organisation = new Organisation();
            $organisation->setName('Association ' . $i);
            $organisation->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Suspendisse sed tristique justo. Morbi luctus, eros a fringilla fringilla, leo ligula dignissim arcu, at congue ipsum arcu ac ante. 
            Sed suscipit orci quis luctus viverra. 
            Quisque sed porttitor ex, eleifend ultrices orci. Sed ligula enim, facilisis vel elit a, porttitor congue ligula. 
            Nunc in leo at ligula bibendum pulvinar. Sed convallis porttitor tristique. 
            Phasellus nisi erat, finibus at odio ac, euismod vehicula mi.'
            );
            $images = [];
            for ($j = 1; $j < mt_rand(1, 3); $j++) {
                $images[] = str_replace('%d', mt_rand(1, 10), 'organisation%d.jpg');
            }
            $organisation->setImages($images);
            $organisation->setLogo('logo' . mt_rand(1, 9) . '.jpg');

            $organisation->setUsers(new ArrayCollection($manager->getRepository(User::class)->findAll()));

            $manager->persist($organisation);
        }
        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }
}
