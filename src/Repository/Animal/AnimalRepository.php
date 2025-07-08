<?php

namespace App\Repository\Animal;

use App\Entity\Animal\Animal;
use App\Model\SearchAnimal;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AnimalRepository extends EntityRepository
{
    public function search(
        int $page = 1,
        int $pageSize = 20
    ): Paginator {
        $queryBuilder = $this->createQueryBuilder('animal');
        $query = $queryBuilder->getQuery();
        $query
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize);

        return new Paginator($query);
    }


    public function findBySearch(
        SearchAnimal $searchAnimal,
        int $page = 1,
        int $pageSize = 20
    ): Paginator {
        $queryBuilder = $this->createQueryBuilder('animal');

        if (isset($searchAnimal->type)) {
            $type = $searchAnimal->type; // 'dog' ou 'cat'

            //TODO Fix me
            if (isset(Animal::DISCRIMINATOR_MAP[$type])) {
                $queryBuilder->andWhere('animal INSTANCE OF :type')
                    ->setParameter('type', Animal::DISCRIMINATOR_MAP[$type]);
            }
        }

        if (isset($searchAnimal->name)) {
            $queryBuilder->andWhere('animal.name LIKE :name')->setParameter('name', '%' . $searchAnimal->name . '%');
        }
        if (isset($searchAnimal->sex)) {
            $queryBuilder->andWhere('animal.sex = :sex')->setParameter('sex', $searchAnimal->sex);
        }
        if (isset($searchAnimal->fur)) {
            $queryBuilder->andWhere('animal.fur = :fur')->setParameter('fur', $searchAnimal->fur);
        }
        if (isset($searchAnimal->color)) {
            $queryBuilder->andWhere('animal.color = :color')->setParameter('color', $searchAnimal->color);
        }
        if (isset($searchAnimal->vaccination)) {
            $queryBuilder->andWhere('animal.vaccination = :vaccination')->setParameter('vaccination', $searchAnimal->vaccination);
        }
        if (isset($searchAnimal->sterilized)) {
            $queryBuilder->andWhere('animal.sterilized = :sterilized')->setParameter('sterilized', $searchAnimal->sterilized);
        }
        if (isset($searchAnimal->dewormed)) {
            $queryBuilder->andWhere('animal.dewormed = :dewormed')->setParameter('dewormed', $searchAnimal->dewormed);
        }
        if (isset($searchAnimal->dogsAffinities)) {
            $queryBuilder->andWhere('animal.dogsAffinities = :dogsAffinities')->setParameter('dogsAffinities', $searchAnimal->dogsAffinities);
        }
        if (isset($searchAnimal->catsAffinities)) {
            $queryBuilder->andWhere('animal.catsAffinities = :catsAffinities')->setParameter('catsAffinities', $searchAnimal->catsAffinities);
        }
        if (isset($searchAnimal->childAffinities)) {
            $queryBuilder->andWhere('animal.childAffinities = :childAffinities')->setParameter('childAffinities', $searchAnimal->childAffinities);
        }

        $query = $queryBuilder->getQuery();

        $query
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize);

        return new Paginator($query);
    }

    public function findLasts(int $pageSize = 6): array
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
            ->addOrderBy('animal.birthDate', Order::Descending->value)
            ->setMaxResults($pageSize)
            ->getQuery()
            ->getResult();
    }
}
