<?php

namespace App\Repository\AdoptionRequest;

use App\Entity\Animal\Animal;
use App\Entity\Organisation;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class AdoptionRequestRepository extends EntityRepository
{
    public function findByUser(UserInterface $user, ?int $limit = null): array
    {
        $queryBuilder = $this->createQueryBuilder('adoption_request');

        $queryBuilder->join('adoption_request.animal', 'ar_animal');
        $queryBuilder->where('ar_animal.manager = :user');

        $queryBuilder->setParameter('user', $user);

        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }

        $queryBuilder->orderBy('adoption_request.createdAt', Order::Descending->value);

        return $queryBuilder->getQuery()->getResult();
    }
    public function findByOrganisation(Organisation $organisation, ?int $limit = null): array
    {
        $queryBuilder = $this->createQueryBuilder('adoption_request');

        $queryBuilder->join('adoption_request.animal', 'ar_animal');
        $queryBuilder->where('ar_animal.organisation = :organisation');

        $queryBuilder->setParameter('organisation', $organisation);

        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }

        $queryBuilder->orderBy('adoption_request.createdAt', Order::Descending->value);

        return $queryBuilder->getQuery()->getResult();
    }

    public function findByAnimal(Animal $animal, ?int $limit = null): array
    {
        $queryBuilder = $this->createQueryBuilder('adoption_request');

        $queryBuilder->join('adoption_request.animal', 'ar_animal');
        $queryBuilder->where('adoption_request.animal = :animal');

        $queryBuilder->setParameter('animal', $animal);

        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }

        $queryBuilder->orderBy('adoption_request.createdAt', Order::Descending->value);

        return $queryBuilder->getQuery()->getResult();
    }
}
