<?php

namespace App\Command;

use App\Entity\Praticien;
use App\Entity\Specialite;
use App\Entity\Structure;
use App\Entity\MotifVisite;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'td:ex1',
    description: 'Exercice 1 – Manipulations Doctrine ORM'
)]
class Exercice1Command extends Command
{

    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("=== EXERCICE 1 : Doctrine ORM ===");

        // 1
        $specialite = $this->em->getRepository(Specialite::class)->find(1);
        $output->writeln("\n1) Spécialité 1");
        $output->writeln("ID : {$specialite->getId()}");
        $output->writeln("Libellé : {$specialite->getLibelle()}");
        $output->writeln("Description : {$specialite->getDescription()}");

        // 2 + 3
        $idPraticien = '8ae1400f-d46d-3b50-b356-269f776be532';
        $p = $this->em->getRepository(Praticien::class)->find($idPraticien);

        $output->writeln("\n2) Praticien {$idPraticien}");
        $output->writeln("Nom : {$p->getNom()} {$p->getPrenom()}");
        $output->writeln("Ville : {$p->getVille()}");
        $output->writeln("Email : {$p->getEmail()}");
        $output->writeln("Téléphone : {$p->getTelephone()}");

        $output->writeln("\n3) Spécialité & Structure");
        $output->writeln("Spécialité : {$p->getSpecialite()->getLibelle()}");
        $output->writeln("Structure : " . ($p->getStructure()?->getNom() ?? 'Aucune'));

        // 4
        $structureId = '3444bdd2-8783-3aed-9a5e-4d298d2a2d7c';
        $structure = $this->em->getRepository(Structure::class)->find($structureId);

        $output->writeln("\n4) Structure {$structure->getNom()}");
        foreach ($structure->getPraticiens() as $praticien) {
            $output->writeln("- {$praticien->getNom()} {$praticien->getPrenom()}");
        }

        // 5
        $output->writeln("\n5) Motifs de la spécialité 1");
        foreach ($specialite->getMotifs() as $motif) {
            $output->writeln("- {$motif->getLibelle()}");
        }

        // 6
        $output->writeln("\n6) Motifs du praticien");
        foreach ($p->getMotifs() as $motif) {
            $output->writeln("- {$motif->getLibelle()}");
        }

        // 7) Créer un praticien (spécialité pédiatrie)
        $output->writeln("\n7) Création d'un praticien (pédiatrie)");

        $specialitePediatrie = $this->em
            ->getRepository(Specialite::class)
            ->findOneBy(['libelle' => 'pédiatrie']);

        $newPraticien = new Praticien();
        $newPraticien->setId(sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0x0fff) | 0x4000,
            random_int(0, 0x3fff) | 0x8000,
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0xffff)
        ));
        $newPraticien->setNom('Dupont');
        $newPraticien->setPrenom('Alice');
        $newPraticien->setVille('Lyon');
        $newPraticien->setEmail('alice.dupont@test.fr');
        $newPraticien->setTelephone('0102030405');
        $newPraticien->setSpecialite($specialitePediatrie);

        $this->em->persist($newPraticien);
        $this->em->flush();

        $output->writeln("Praticien créé avec ID : {$newPraticien->getId()}");

        // 8) Modifier le praticien
        $output->writeln("\n8) Modification du praticien");

        $structureBigot = $this->em
            ->getRepository(Structure::class)
            ->findOneBy(['nom' => 'Cabinet Bigot']);

        $newPraticien->setStructure($structureBigot);
        $newPraticien->setVille('Paris');

        // Ajout de motifs de visite (ceux de la pédiatrie)
        foreach ($specialitePediatrie->getMotifs() as $motif) {
            $newPraticien->addMotif($motif);
        }

        $this->em->flush();

        $output->writeln("Praticien modifié (structure, ville, motifs)");

        // 9) Supprimer le praticien
        $output->writeln("\n9) Suppression du praticien");

        $this->em->remove($newPraticien);
        $this->em->flush();

        $output->writeln("Praticien supprimé de la base");

        return Command::SUCCESS;
    }
}
