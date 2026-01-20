<?php

namespace App\Repository;

use App\Entity\Specialite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SpecialiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Specialite::class);
    }

    /**
     * Liste des spécialités contenant un mot-clé dans le libellé ou la description
     */
    public function findByKeyword(string $keyword): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.libelle LIKE :kw OR s.description LIKE :kw')
            ->setParameter('kw', "%$keyword%")
            ->getQuery()
            ->getResult();
    }
}