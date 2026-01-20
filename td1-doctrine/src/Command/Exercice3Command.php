<?php

namespace App\Command;

use App\Repository\SpecialiteRepository;
use App\Repository\PraticienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'td:ex3',
    description: 'Exercice 3 – Repository et DQL'
)]
class Exercice3Command extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private SpecialiteRepository $specialiteRepo,
        private PraticienRepository $praticienRepo
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("=== EXERCICE 3 : Repository et DQL ===");

        // 1) Spécialités contenant un mot clé
        $output->writeln("\n1) Spécialités contenant 'médecine'");
        $specialites = $this->specialiteRepo->findByKeyword('médecine');
        foreach ($specialites as $s) {
            $output->writeln("- {$s->getLibelle()} ({$s->getDescription()})");
        }

        // 2) Praticiens dont la spécialité contient 'pédiatrie'
        $output->writeln("\n2) Praticiens dont la spécialité contient 'pédiatrie'");
        $praticiens = $this->praticienRepo->findBySpecialiteKeyword('pédiatrie');
        foreach ($praticiens as $p) {
            $output->writeln("- {$p->getNom()} {$p->getPrenom()} ({$p->getVille()})");
        }

        // 3) Praticiens d’une spécialité et acceptant un moyen de paiement
        $output->writeln("\n3) Praticiens de 'ophtalmologie' acceptant le moyen de paiement 1");
        $praticiens2 = $this->praticienRepo->findBySpecialiteAndMoyen('ophtalmologie', 1);
        foreach ($praticiens2 as $p) {
            $output->writeln("- {$p->getNom()} {$p->getPrenom()} ({$p->getVille()})");
        }

        return Command::SUCCESS;
    }
}
