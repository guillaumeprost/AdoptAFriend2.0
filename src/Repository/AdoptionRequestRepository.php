<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class AdoptionRequestRepository extends EntityRepository
{
    public function findByUser(UserInterface $user, $limit = false): array
    {
        $queryBuilder = $this->createQueryBuilder('adoption_request');

        $queryBuilder->join('adoption_request.animal', 'ar_animal');
        $queryBuilder->where('ar_animal.manager = :user');

        $queryBuilder->setParameter('user', $user);

        if ($limit !== false) {
            $queryBuilder->setMaxResults($limit);
        }
        $queryBuilder->orderBy('adoption_request.createdAt', 'DESC');

        return $queryBuilder->getQuery()->getResult();
    }
}