<?php

namespace App\Command;

use App\Entity\Praticien;
use App\Entity\Specialite;
use App\Entity\Structure;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'td:ex2',
    description: 'Exercice 2 – Requêtes Doctrine avec conditions'
)]
class Exercice2Command extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("=== EXERCICE 2 : Requêtes avec conditions ===");

        // 1) Praticien par email
        $output->writeln("\n1) Praticien par email");
        $praticien = $this->em->getRepository(Praticien::class)
            ->findOneBy(['email' => 'Gabrielle.Klein@live.com']);
        $output->writeln("- {$praticien->getNom()} {$praticien->getPrenom()} ({$praticien->getVille()})");

        // 2) Praticien par nom et ville
        $output->writeln("\n2) Praticien de nom Goncalves à Paris");
        $praticien2 = $this->em->getRepository(Praticien::class)
            ->findOneBy(['nom' => 'Goncalves', 'ville' => 'Paris']);
        $output->writeln("- {$praticien2->getNom()} {$praticien2->getPrenom()} ({$praticien2->getEmail()})");

        // 3) Spécialité 'pédiatrie' avec praticiens associés
        $output->writeln("\n3) Spécialité pédiatrie et praticiens");
        $specialite = $this->em->getRepository(Specialite::class)
            ->findOneBy(['libelle' => 'pédiatrie']);
        $output->writeln("- {$specialite->getLibelle()}");
        foreach ($specialite->getPraticiens() as $p) {
            $output->writeln("  - {$p->getNom()} {$p->getPrenom()} ({$p->getVille()})");
        }

        // 4) Groupements contenant 'santé' (requête critères)
        $output->writeln("\n4) Groupements contenant 'santé' dans leur description");
        $qb = $this->em->createQueryBuilder();
        $qb->select('s')
            ->from(Structure::class, 's')
            ->where($qb->expr()->like('s.nom', ':term'))
            ->setParameter('term', '%santé%');
        $groupements = $qb->getQuery()->getResult();
        foreach ($groupements as $g) {
            $output->writeln("- {$g->getNom()} ({$g->getVille()})");
        }

        // 5) Praticiens d'ophtalmologie à Paris
        $output->writeln("\n5) Praticiens ophtalmologie à Paris");
        $qb2 = $this->em->createQueryBuilder();
        $qb2->select('p')
            ->from(Praticien::class, 'p')
            ->join('p.specialite', 's')
            ->where('s.libelle = :libelle')
            ->andWhere('p.ville = :ville')
            ->setParameter('libelle', 'ophtalmologie')
            ->setParameter('ville', 'Paris');
        $ophtalmos = $qb2->getQuery()->getResult();
        foreach ($ophtalmos as $o) {
            $output->writeln("- {$o->getNom()} {$o->getPrenom()} ({$o->getEmail()})");
        }

        return Command::SUCCESS;
    }
}