<?php

namespace App\EventListeners;

use App\Entity\Animal\Animal;
use App\Entity\Organisation;
use App\Entity\User;
use App\Service\AnimalService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Animal::class)]
class AnimalListener
{
    public function prePersist(Animal $animal, PrePersistEventArgs $event): void
    {
        // TODO: inject TokenStorageInterface and set manager/organisation on persist
    }
}
