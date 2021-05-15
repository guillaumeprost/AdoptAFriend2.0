<?php


namespace App\Repository;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AnimalRepository extends EntityRepository
{
    /**
     * @param array $filers
     * @param array $sorters
     * @param int $page
     * @param int $pageSize
     * @return Paginator
     */
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
            ->setFirstResult($pageSize * ($page-1)) // set the offset
            ->setMaxResults($pageSize); // set the limit

        return new Paginator($query);
    }

    public function findLastSix()
    {
        $queryBuilder = $this->createQueryBuilder('animal');
        $queryBuilder->addOrderBy('animal.createdAt', 'ASC');
        $queryBuilder->setMaxResults(6);

        return $queryBuilder->getQuery()->getResult();
    }
}