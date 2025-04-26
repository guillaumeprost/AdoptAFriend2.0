<?php

namespace App\EventListeners;

use App\Entity\Animal\Animal;
use App\Entity\Organisation;
use App\Entity\User;
use App\Service\AnimalService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Animal::class)]
class AnimalListener
{
    public function __construct()
    {
    }

    public function prePersist(Animal $animal, LifecycleEventArgs $event): Animal
    {
        //TODO Fix me
        /*$user = $this->tokenStorage->getToken()->getUser();

        if (! $user instanceof User) {
            return $animal;
        }

        $animal->setManager($user);

        if ($user->getOrganisation() instanceof Organisation) {
            $animal->setOrganisation($user->getOrganisation());
        }*/

        return $animal;
    }
}
