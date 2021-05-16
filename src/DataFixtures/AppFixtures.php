<?php

namespace App\DataFixtures;

use App\Entity\Animal\Dog;
use App\Entity\User;
use App\Utils\Animal\Affinities;
use App\Utils\Animal\Color;
use App\Utils\Animal\Dog\Size;
use App\Utils\Animal\Fur;
use App\Utils\Animal\Sex;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {

    }
}
