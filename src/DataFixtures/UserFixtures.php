<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1
            ->setEmail('bruce@wayne.com')
            ->setName('Wayne')
            ->setFirstName('Bruce')
            ->setPassword(
                $this->passwordEncoder->encodePassword(
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
                $this->passwordEncoder->encodePassword(
                    $user2,
                    'testtest'
                )
            );

        $manager->persist($user2);
        $manager->flush();
    }
}