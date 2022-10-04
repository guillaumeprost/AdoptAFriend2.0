<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1
            ->setEmail('bruce@wayne.com')
            ->setName('Wayne')
            ->setFirstName('Bruce')
            ->setPassword(
                $this->passwordHasher->hashPassword(
                    $user1,
                    'batmanroxx'
                )
            );

        $manager->persist($user1);
        $user2 = new User();
        $user2
            ->setEmail('test@test.com')
            ->setName('Doe')
            ->setFirstName('John')
            ->setPassword(
                $this->passwordHasher->hashPassword(
                    $user2,
                    'testtest'
                )
            );

        $manager->persist($user2);
        $manager->flush();
    }
}