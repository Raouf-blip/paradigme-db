<?php

namespace App\Repository;

use App\Entity\Structure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StructureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Structure::class);
    }

    public function findWithPraticiens(string $id): ?Structure
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.praticiens', 'p')->addSelect('p')
            ->where('s.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
