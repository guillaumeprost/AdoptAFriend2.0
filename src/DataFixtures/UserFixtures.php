<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher){}

    #[NoReturn]
    public function load(ObjectManager $manager)
    {
        //User Batman
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
            )
        ;

        try {
            $manager->persist($user1);
        } catch (\Exception $exception) {
            dd($exception);
        }


        //User Test
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
