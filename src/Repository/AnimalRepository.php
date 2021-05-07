<?php


namespace App\Repository;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\OrderBy;

class AnimalRepository extends EntityRepository
{
    /**
     * @param array $filers
     * @param array $sorters
     * @return ArrayCollection
     */
    public function search(array $filers,array $sorters)
    {
        $queryBuilder = $this->createQueryBuilder('animal');
        $results = $queryBuilder->getQuery()->getResult();

        return $results;
    }

    public function findLastSix()
    {
        $queryBuilder = $this->createQueryBuilder('animal');
        $queryBuilder->addOrderBy('animal.createdAt', 'ASC');
        $queryBuilder->setMaxResults(6);

        return $queryBuilder->getQuery()->getResult();
    }
}