<?php

namespace App\Repository;

use App\Entity\Praticien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PraticienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Praticien::class);
    }

    /**
     * Liste des praticiens dont la spécialité contient un mot-clé dans libellé ou description
     */
    public function findBySpecialiteKeyword(string $keyword): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.specialite', 's')
            ->where('s.libelle LIKE :kw OR s.description LIKE :kw')
            ->setParameter('kw', "%$keyword%")
            ->getQuery()
            ->getResult();
    }

    /**
     * Liste des praticiens d’une spécialité et acceptant un moyen de paiement donné
     */
    public function findBySpecialiteAndMoyen(string $specialiteLibelle, int $moyenId): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.specialite', 's')
            ->join('p.moyensPaiement', 'm')
            ->where('s.libelle = :spec')
            ->andWhere('m.id = :mid')
            ->setParameter('spec', $specialiteLibelle)
            ->setParameter('mid', $moyenId)
            ->getQuery()
            ->getResult();
    }
}