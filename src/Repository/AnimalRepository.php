<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AnimalRepository extends EntityRepository
{
    public function search(
        array $filers = [],
        array $sorters = [],
        int   $page = 1,
        int   $pageSize = 20
    ): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('animal');
        $query = $queryBuilder->getQuery();
        $query
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize);

        return new Paginator($query);
    }

    public function findLasts(int $pageSize = 5): array
    {
        return $this
            ->createQueryBuilder('animal')
            ->addOrderBy('animal.createdAt', 'ASC')
            ->setMaxResults($pageSize)
            ->getQuery()
            ->getResult();
    }

    public function findOldest(int $pageSize = 5): array
    {
        return $this
            ->createQueryBuilder('animal')
            ->addOrderBy('animal.birthDate', 'DESC')
            ->setMaxResults($pageSize)
            ->getQuery()
            ->getResult();
    }
}