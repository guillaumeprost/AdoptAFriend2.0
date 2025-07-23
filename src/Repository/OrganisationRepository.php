<?php

namespace App\Repository;

use App\Model\SearchOrganisation;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class OrganisationRepository extends EntityRepository
{
    public function search(
        int $page = 1,
        int $pageSize = 20
    ): Paginator {
        $queryBuilder = $this->createQueryBuilder('organisation');
        $query = $queryBuilder->getQuery();
        $query
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize);

        return new Paginator($query);
    }

    public function findBySearch(
        SearchOrganisation $searchOrganisation,
        int $page = 1,
        int $pageSize = 20
    ): Paginator {
        $queryBuilder = $this->createQueryBuilder('organisation');

        if (isset($searchOrganisation->name)) {
            $queryBuilder->andWhere('organisation.name LIKE :name')->setParameter('name', '%' . $searchOrganisation->name . '%');
        }

        $query = $queryBuilder->getQuery();
        $query
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize);

        return new Paginator($query);
    }

    public function findLasts(int $pageSize = 4): array
    {
        return $this
            ->createQueryBuilder('organisation')
            ->addOrderBy('organisation.createdAt', 'ASC')
            ->setMaxResults($pageSize)
            ->getQuery()
            ->getResult();
    }
}
