<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    public const USER_REFERENCE = 'user';

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

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

        $this->addReference(self::USER_REFERENCE .'1', $user1);

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
        $this->addReference(self::USER_REFERENCE .'2', $user1);

        $manager->persist($user2);
        $manager->flush();


        //User Test
        $user2 = new User();
        $user2
            ->setEmail('guillaume.prost0@gmail.com')
            ->setName('Guillaume')
            ->setFirstName('Prost')
            ->setPassword(
                $this->passwordHasher->hashPassword(
                    $user2,
                    'adoptme'
                )
            );

        $this->addReference(self::USER_REFERENCE .'3', $user1);

        $manager->persist($user2);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
