<?php


namespace App\Repository;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

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
}