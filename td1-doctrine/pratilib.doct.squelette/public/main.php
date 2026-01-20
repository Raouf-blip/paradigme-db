<?php
/**
 * TP1 - Doctrine ORM
 * Toutes les réponses aux exercices
 */

use toubeelib\praticien\entity\Specialite;
use toubeelib\praticien\entity\Praticien;
use toubeelib\praticien\entity\Structure;
use toubeelib\praticien\entity\MotifVisite;
use toubeelib\praticien\entity\MoyenPaiement;

$entityManager = require_once __DIR__ . '/../config/bootstrap.php';

echo "<h1>TP1 - Doctrine ORM - Réponses aux exercices</h1>";
echo "<style>body { font-family: Arial; padding: 20px; } pre { background: #f5f5f5; padding: 10px; border-left: 3px solid #007bff; }</style>";

// --- Exercice 1 : utilisation élémentaire ---
echo "<h2>📚 Exercice 1 : Utilisation élémentaire</h2>";

// 1.1 Spécialité id=1
echo "<h3>1.1 - Spécialité ID 1</h3>";
$specialite1 = $entityManager->find(Specialite::class, 1);
if ($specialite1) {
    echo "<pre>";
    echo "ID: " . $specialite1->getId() . "\n";
    echo "Libellé: " . $specialite1->getLibelle() . "\n";
    echo "Description: " . ($specialite1->getDescription() ?? 'N/A') . "\n";
    echo "</pre>";
} else {
    echo "<p style='color:red'>❌ Spécialité non trouvée</p>";
}

// 1.2 Praticien id=8ae1400f-d46d-3b50-b356-269f776be532
echo "<h3>1.2 - Praticien ID 8ae1400f-d46d-3b50-b356-269f776be532</h3>";
$praticien = $entityManager->find(Praticien::class, '8ae1400f-d46d-3b50-b356-269f776be532');
if ($praticien) {
    echo "<pre>";
    echo "ID: " . $praticien->getId() . "\n";
    echo "Nom: " . $praticien->getNom() . "\n";
    echo "Prénom: " . $praticien->getPrenom() . "\n";
    echo "Ville: " . $praticien->getVille() . "\n";
    echo "Email: " . $praticien->getEmail() . "\n";
    echo "Téléphone: " . $praticien->getTelephone() . "\n";
    echo "</pre>";
} else {
    echo "<p style='color:red'>❌ Praticien non trouvé</p>";
}

// 1.3 Compléter avec spécialité et structure
echo "<h3>1.3 - Praticien avec spécialité et structure</h3>";
if ($praticien) {
    echo "<pre>";
    echo "Praticien: " . $praticien->getPrenom() . " " . $praticien->getNom() . "\n";
    echo "Spécialité: " . $praticien->getSpecialite()->getLibelle() . "\n";
    $structure = $praticien->getStructure();
    echo "Structure: " . ($structure ? $structure->getNom() : "❌ Aucune") . "\n";
    if ($structure) {
        echo "Adresse: " . $structure->getAdresse() . "\n";
    }
    echo "</pre>";
}

// 1.4 Structure avec liste des praticiens
echo "<h3>1.4 - Structure avec liste des praticiens</h3>";
$structure = $entityManager->find(Structure::class, '3444bdd2-8783-3aed-9a5e-4d298d2a2d7c');
if ($structure) {
    echo "<pre>";
    echo "Structure: " . $structure->getNom() . "\n";
    echo "Ville: " . ($structure->getVille() ?? 'N/A') . "\n";
    echo "\nPraticiens rattachés (" . $structure->getPraticiens()->count() . "):\n";
    foreach ($structure->getPraticiens() as $p) {
        echo "  ✓ " . $p->getTitre() . " " . $p->getPrenom() . " " . $p->getNom();
        echo " (" . $p->getSpecialite()->getLibelle() . ")\n";
    }
    echo "</pre>";
} else {
    echo "<p style='color:red'>❌ Structure non trouvée</p>";
}

// 1.5 Spécialité avec motifs de visite
echo "<h3>1.5 - Spécialité ID 1 avec motifs de visite</h3>";
if ($specialite1) {
    echo "<pre>";
    echo "Spécialité: " . $specialite1->getLibelle() . "\n";
    echo "\nMotifs de visite (" . $specialite1->getMotifsVisite()->count() . "):\n";
    foreach ($specialite1->getMotifsVisite() as $motif) {
        echo "  • " . $motif->getLibelle() . "\n";
    }
    echo "</pre>";
}

// 1.6 Motifs de visite du praticien
echo "<h3>1.6 - Motifs de visite du praticien</h3>";
if ($praticien) {
    echo "<pre>";
    echo "Praticien: " . $praticien->getPrenom() . " " . $praticien->getNom() . "\n";
    echo "\nMotifs de visite (" . $praticien->getMotifsVisite()->count() . "):\n";
    if ($praticien->getMotifsVisite()->count() > 0) {
        foreach ($praticien->getMotifsVisite() as $motif) {
            echo "  • " . $motif->getLibelle() . "\n";
        }
    } else {
        echo "  (Aucun motif de visite)\n";
    }
    echo "</pre>";
}

// 1.7 Créer un praticien
echo "<h3>1.7 - Création d'un praticien (pédiatrie)</h3>";
$specialitePediatrie = $entityManager->getRepository(Specialite::class)
    ->findOneBy(['libelle' => 'pédiatrie']);

if ($specialitePediatrie) {
    $nouveauPraticien = new Praticien();
    $nouveauPraticien->setNom('Dupont');
    $nouveauPraticien->setPrenom('Jean');
    $nouveauPraticien->setVille('Nancy');
    $nouveauPraticien->setEmail('jean.dupont@example.com');
    $nouveauPraticien->setTelephone('03 83 00 00 00');
    $nouveauPraticien->setSpecialite($specialitePediatrie);

    $entityManager->persist($nouveauPraticien);
    $entityManager->flush();

    echo "<pre>";
    echo "✅ Nouveau praticien créé!\n";
    echo "ID: " . $nouveauPraticien->getId() . "\n";
    echo "Nom complet: " . $nouveauPraticien->getPrenom() . " " . $nouveauPraticien->getNom() . "\n";
    echo "Spécialité: " . $nouveauPraticien->getSpecialite()->getLibelle() . "\n";
    echo "</pre>";

    $nouveauPraticienId = $nouveauPraticien->getId();

    // 1.8 Modifier le praticien
    echo "<h3>1.8 - Modification du praticien</h3>";
    
    $cabinetBigot = $entityManager->getRepository(Structure::class)
        ->findOneBy(['nom' => 'Cabinet Bigot']);
    if ($cabinetBigot) {
        $nouveauPraticien->setStructure($cabinetBigot);
    }

    $nouveauPraticien->setVille('Paris');

    $motifsVisite = $entityManager->getRepository(MotifVisite::class)
        ->findBy(['specialite' => $specialitePediatrie], null, 3);
    foreach ($motifsVisite as $motif) {
        $nouveauPraticien->addMotifVisite($motif);
    }

    $entityManager->flush();

    echo "<pre>";
    echo "✅ Praticien modifié!\n";
    echo "Nouvelle ville: " . $nouveauPraticien->getVille() . "\n";
    echo "Structure: " . ($nouveauPraticien->getStructure() ? $nouveauPraticien->getStructure()->getNom() : "Aucune") . "\n";
    echo "Motifs de visite (" . $nouveauPraticien->getMotifsVisite()->count() . "):\n";
    foreach ($nouveauPraticien->getMotifsVisite() as $motif) {
        echo "  • " . $motif->getLibelle() . "\n";
    }
    echo "</pre>";

    // 1.9 Supprimer le praticien
    echo "<h3>1.9 - Suppression du praticien</h3>";
    $entityManager->remove($nouveauPraticien);
    $entityManager->flush();
    echo "<pre>✅ Praticien supprimé avec succès! (ID: $nouveauPraticienId)</pre>";
} else {
    echo "<p style='color:red'>❌ Spécialité pédiatrie non trouvée</p>";
}

// --- Exercice 2 ---
echo "<hr><h2>🔍 Exercice 2 : Requêtes avec conditions de sélection</h2>";

// 2.1 Praticien par email
echo "<h3>2.1 - Praticien par email (Gabrielle.Klein@live.com)</h3>";
$praticienEmail = $entityManager->getRepository(Praticien::class)
    ->findOneBy(['email' => 'Gabrielle.Klein@live.com']);
if ($praticienEmail) {
    echo "<pre>";
    echo "✓ Trouvé: " . $praticienEmail->getPrenom() . " " . $praticienEmail->getNom() . "\n";
    echo "Email: " . $praticienEmail->getEmail() . "\n";
    echo "Ville: " . $praticienEmail->getVille() . "\n";
    echo "Spécialité: " . $praticienEmail->getSpecialite()->getLibelle() . "\n";
    echo "</pre>";
} else {
    echo "<p style='color:orange'>⚠️ Aucun praticien trouvé avec cet email</p>";
}

// 2.2 Praticien Goncalves à Paris
echo "<h3>2.2 - Praticien Goncalves à Paris</h3>";
$goncalves = $entityManager->getRepository(Praticien::class)
    ->findOneBy(['nom' => 'Goncalves', 'ville' => 'Paris']);
if ($goncalves) {
    echo "<pre>";
    echo "✓ Trouvé: " . $goncalves->getPrenom() . " " . $goncalves->getNom() . "\n";
    echo "Ville: " . $goncalves->getVille() . "\n";
    echo "Email: " . $goncalves->getEmail() . "\n";
    echo "Spécialité: " . $goncalves->getSpecialite()->getLibelle() . "\n";
    echo "</pre>";
} else {
    echo "<p style='color:orange'>⚠️ Aucun praticien trouvé</p>";
}

// 2.3 Spécialité pédiatrie avec praticiens
echo "<h3>2.3 - Spécialité pédiatrie avec praticiens</h3>";
$pediatrie = $entityManager->getRepository(Specialite::class)
    ->findOneBy(['libelle' => 'pédiatrie']);
if ($pediatrie) {
    echo "<pre>";
    echo "Spécialité: " . $pediatrie->getLibelle() . "\n";
    echo "Description: " . ($pediatrie->getDescription() ?? 'N/A') . "\n";
    echo "\nPraticiens (" . $pediatrie->getPraticiens()->count() . "):\n";
    foreach ($pediatrie->getPraticiens() as $p) {
        echo "  • " . $p->getPrenom() . " " . $p->getNom() . " - " . $p->getVille() . "\n";
    }
    echo "</pre>";
}

// 2.4 Spécialités contenant un mot-clé (QueryBuilder)
echo "<h3>2.4 - Spécialités contenant 'Médecine' (QueryBuilder)</h3>";
$qb = $entityManager->createQueryBuilder();
$qb->select('s')
   ->from(Specialite::class, 's')
   ->where($qb->expr()->like('s.description', ':keyword'))
   ->setParameter('keyword', '%Médecine%');
$specialitesMedecine = $qb->getQuery()->getResult();

echo "<pre>";
echo "Résultats (" . count($specialitesMedecine) . "):\n";
foreach ($specialitesMedecine as $s) {
    echo "  • " . $s->getLibelle() . "\n";
    echo "    → " . substr($s->getDescription() ?? '', 0, 60) . "...\n";
}
echo "</pre>";

// 2.5 Praticiens ophtalmologie à Paris (DQL)
echo "<h3>2.5 - Praticiens ophtalmologie à Paris (DQL)</h3>";
$dql = "SELECT p FROM toubeelib\praticien\entity\Praticien p
        JOIN p.specialite s
        WHERE s.libelle = :specialite AND p.ville = :ville";
$praticiensParis = $entityManager->createQuery($dql)
    ->setParameter('specialite', 'ophtalmologie')
    ->setParameter('ville', 'Paris')
    ->getResult();

echo "<pre>";
echo "Résultats (" . count($praticiensParis) . "):\n";
foreach ($praticiensParis as $p) {
    echo "  • " . $p->getTitre() . " " . $p->getPrenom() . " " . $p->getNom() . "\n";
    echo "    Email: " . $p->getEmail() . "\n";
}
echo "</pre>";

// --- Exercice 3 ---
echo "<hr><h2>📦 Exercice 3 : Repository et DQL</h2>";

// 3.1 Spécialités par mot-clé
echo "<h3>3.1 - Spécialités par mot-clé (exemple: 'cardio')</h3>";
$specialiteRepo = $entityManager->getRepository(Specialite::class);
$specialitesKeyword = $specialiteRepo->findByKeyword('cardio');
echo "<pre>";
echo "Résultats pour 'cardio' (" . count($specialitesKeyword) . "):\n";
foreach ($specialitesKeyword as $s) {
    echo "  • " . $s->getLibelle() . "\n";
    if ($s->getDescription()) {
        echo "    " . substr($s->getDescription(), 0, 60) . "...\n";
    }
}
echo "</pre>";

// 3.2 Praticiens par mot-clé dans spécialité
echo "<h3>3.2 - Praticiens par mot-clé dans spécialité (exemple: 'médecine')</h3>";
$praticienRepo = $entityManager->getRepository(Praticien::class);
$praticiensSpecKeyword = $praticienRepo->findBySpecialiteKeyword('médecine');
echo "<pre>";
echo "Résultats pour 'médecine' (" . count($praticiensSpecKeyword) . "):\n";
$count = 0;
foreach ($praticiensSpecKeyword as $p) {
    if ($count++ < 10) { // Limiter l'affichage à 10
        echo "  • " . $p->getPrenom() . " " . $p->getNom();
        echo " (" . $p->getSpecialite()->getLibelle() . ") - " . $p->getVille() . "\n";
    }
}
if (count($praticiensSpecKeyword) > 10) {
    echo "  ... et " . (count($praticiensSpecKeyword) - 10) . " autres\n";
}
echo "</pre>";

// 3.3 Praticiens par spécialité et moyen de paiement
echo "<h3>3.3 - Praticiens par spécialité et moyen de paiement</h3>";
$spec1 = $entityManager->find(Specialite::class, 1);
$moyens = $entityManager->getRepository(MoyenPaiement::class)->findAll();
if ($spec1 && count($moyens) > 0) {
    $moyen1 = $moyens[0];
    $praticiensMP = $praticienRepo->findBySpecialiteAndMoyenPaiement($spec1->getId(), $moyen1->getId());
    echo "<pre>";
    echo "Spécialité: " . $spec1->getLibelle() . "\n";
    echo "Moyen de paiement: " . $moyen1->getLibelle() . "\n";
    echo "\nRésultats (" . count($praticiensMP) . "):\n";
    foreach ($praticiensMP as $p) {
        echo "  • " . $p->getPrenom() . " " . $p->getNom() . " - " . $p->getVille() . "\n";
    }
    echo "</pre>";
}

echo "<hr><p><strong>✅ Fin des exercices TP1</strong></p>";