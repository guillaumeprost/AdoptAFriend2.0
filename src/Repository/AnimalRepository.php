<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AnimalRepository extends EntityRepository
{
    public function search(
        array $filers = [],
        array $sorters = [],
        int $page = 1,
        int $pageSize = 20
    ): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('animal');
        $query = $queryBuilder->getQuery();
        $query
            ->setFirstResult($pageSize * ($page-1))
            ->setMaxResults($pageSize);

        return new Paginator($query);
    }

    public function findLastSix(): array
    {
        $queryBuilder = $this->createQueryBuilder('animal');
        $queryBuilder->addOrderBy('animal.createdAt', 'ASC');
        $queryBuilder->setMaxResults(6);

        return $queryBuilder->getQuery()->getResult();
    }
}