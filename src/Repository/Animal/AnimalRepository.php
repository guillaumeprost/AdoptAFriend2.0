<?php

namespace App\Repository\Animal;

use App\Entity\Animal\Animal;
use App\Model\SearchAnimal;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class AnimalRepository extends EntityRepository
{
    public function search(
        int $page = 1,
        int $pageSize = 20
    ): Paginator {
        $queryBuilder = $this->createQueryBuilder('animal');
        $queryBuilder
            ->andWhere('animal.status != :adopted')
            ->setParameter('adopted', Animal::STATUS_ADOPTED);
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
            $queryBuilder->andWhere('animal.name LIKE :name')
                ->setParameter('name', '%' . $searchAnimal->name . '%');
        }
        if (isset($searchAnimal->sex)) {
            $queryBuilder->andWhere('animal.sex = :sex')
                ->setParameter('sex', $searchAnimal->sex);
        }
        if (isset($searchAnimal->fur)) {
            $queryBuilder->andWhere('animal.fur = :fur')
                ->setParameter('fur', $searchAnimal->fur);
        }
        if (isset($searchAnimal->color)) {
            $queryBuilder->andWhere('animal.color = :color')
                ->setParameter('color', $searchAnimal->color);
        }
        if (isset($searchAnimal->vaccination)) {
            $queryBuilder->andWhere('animal.vaccination = :vaccination')
                ->setParameter('vaccination', $searchAnimal->vaccination);
        }
        if (isset($searchAnimal->sterilized)) {
            $queryBuilder->andWhere('animal.sterilized = :sterilized')
                ->setParameter('sterilized', $searchAnimal->sterilized);
        }
        if (isset($searchAnimal->dewormed)) {
            $queryBuilder->andWhere('animal.dewormed = :dewormed')
                ->setParameter('dewormed', $searchAnimal->dewormed);
        }
        if (isset($searchAnimal->dogsAffinities)) {
            $queryBuilder->andWhere('animal.dogsAffinities = :dogsAffinities')
                ->setParameter('dogsAffinities', $searchAnimal->dogsAffinities);
        }
        if (isset($searchAnimal->catsAffinities)) {
            $queryBuilder->andWhere('animal.catsAffinities = :catsAffinities')
                ->setParameter('catsAffinities', $searchAnimal->catsAffinities);
        }
        if (isset($searchAnimal->childAffinities)) {
            $queryBuilder->andWhere('animal.childAffinities = :childAffinities')
                ->setParameter('childAffinities', $searchAnimal->childAffinities);
        }


        $queryBuilder
            ->andWhere('animal.status != :adopted')
            ->setParameter('adopted', Animal::STATUS_ADOPTED);

        $query = $queryBuilder->getQuery();

        $query
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize);

        return new Paginator($query);
    }

    public function findLasts(int $pageSize = 4): array
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


    /** Hydrate la colonne geography depuis la WKT stockée (lon lat). */
    public function syncGeography(Animal $animal): void
    {
        if ($animal->getGeo() === null || $animal->getId() === null) return;

        $this->db->executeStatement(
        // ST_GeogFromText attend 'SRID=4326;POINT(lon lat)'
            "UPDATE animal 
             SET geo = ST_GeogFromText(:wkt)
             WHERE id = :id",
            [
                'wkt' => 'SRID=4326;'.$animal->getGeo(),
                'id'  => $animal->getId(),
            ]
        );
    }

    /** Recherche par rayon (km) autour (lat,lng) */
    public function findWithinRadius(float $lat, float $lng, int $radiusKm = 25, int $limit = 100): array
    {
        $meters = $radiusKm * 1000;

        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.geo IS NOT NULL')
            ->addSelect('ST_Distance(a.geo, ST_MakePoint(:lng, :lat)::geography) AS HIDDEN dist')
            ->andWhere('STDWithin(a.geo, ST_MakePoint(:lng, :lat)::geography, :meters) = true')
            ->setParameters([
                'lat' => $lat,
                'lng' => $lng,
                'meters' => $meters,
            ])
            ->orderBy('dist', 'ASC')
            ->setMaxResults($limit);

        return $qb->getQuery()->getArrayResult();
    }
}
