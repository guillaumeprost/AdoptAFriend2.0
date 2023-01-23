<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class OrganisationRepository extends EntityRepository
{
    public function search(
        array $filers = [],
        array $sorters = [],
        int   $page = 1,
        int   $pageSize = 20
    ): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('organisation');
        $query = $queryBuilder->getQuery();
        $query
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize);

        return new Paginator($query);
    }

    public function findLasts(int $pageSize = 5): array
    {
        return $this
            ->createQueryBuilder('organisation')
            ->addOrderBy('organisation.createdAt', 'ASC')
            ->setMaxResults($pageSize)
            ->getQuery()
            ->getResult();
    }
}