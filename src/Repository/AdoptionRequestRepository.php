<?php

namespace App\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\User\UserInterface;

class AdoptionRequestRepository extends EntityRepository
{
    public function findByUser(UserInterface $user,?int $limit = null): array
    {
        $queryBuilder = $this->createQueryBuilder('adoption_request');

        $queryBuilder->join('adoption_request.animal', 'ar_animal');
        $queryBuilder->where('ar_animal.manager = :user');

        $queryBuilder->setParameter('user', $user);

        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }
        $queryBuilder->orderBy('adoption_request.createdAt', Order::Descending);

        return $queryBuilder->getQuery()->getResult();
    }
}