<?php
require_once __DIR__ . '/../vendor/autoload.php';

class MongoConnection
{
    private static ?\MongoDB\Client $client = null;

    public static function getDb(): \MongoDB\Database
    {
        if (!self::$client) {
            self::$client = new \MongoDB\Client('mongodb://mongo-mongo-1:27017');
        }
        return self::$client->selectDatabase('chopizza');
    }
}

$db = MongoConnection::getDb();

// 1) Liste des produits : numero, categorie, libelle
echo "1) Liste des produits:\n";
$produits = $db->produits->find([], ['sort' => ['numero' => 1]]);
foreach ($produits as $prod) {
    $categorie = $prod->categorie ?? 'Inconnue';
    echo "- {$prod->numero} : {$categorie} - {$prod->libelle}\n";
}

// 2) Produit numéro 6
echo "\n2) Produit n°6:\n";
$produit6 = $db->produits->findOne(['numero' => 6]);
if ($produit6) {
    echo "Libellé: {$produit6->libelle}\n";
    echo "Catégorie: " . ($produit6->categorie ?? 'Inconnue') . "\n";
    echo "Description: {$produit6->description}\n";
    echo "Tarifs:\n";
    if (!empty($produit6->tarifs)) {
        foreach ($produit6->tarifs as $tarif) {
            $taille = $tarif->taille ?? 'Inconnue';
            $prix = $tarif->tarif ?? null;
            echo "- {$taille} : {$prix} €\n";
        }
    }
}

// 3) Produits dont le tarif en taille normale <= 3.0
echo "\n3) Produits <= 3€ en taille 'normale':\n";
$produits3 = $db->produits->find([
    'tarifs' => [
        '$elemMatch' => [
            'taille' => 'normale',
            'tarif' => ['$lte' => 3.0]
        ]
    ]
]);
foreach ($produits3 as $prod) {
    $categorie = $prod->categorie ?? 'Inconnue';
    echo "- {$prod->numero} : {$prod->libelle} ({$categorie})\n";
}

// 4) Produits associés à 4 recettes
echo "\n4) Produits associés à 4 recettes:\n";
$produitsRecettes = $db->produits->find([], ['projection' => ['numero', 'libelle', 'recettes']]);
foreach ($produitsRecettes as $prod) {
    if (isset($prod->recettes) && count($prod->recettes) == 4) {
        echo "- {$prod->numero} : {$prod->libelle}\n";
    }
}

// 5) Produit n°6 avec les recettes associées
echo "\n5) Produit n°6 avec ses recettes:\n";
if ($produit6 && !empty($produit6->recettes)) {
    // Convertir BSONArray en array PHP et récupérer ObjectId
    $recettes6Ids = array_map(
        fn($r) => $r instanceof MongoDB\BSON\ObjectId ? $r : new MongoDB\BSON\ObjectId($r->{'$oid'}),
        iterator_to_array($produit6->recettes)
    );

    $recettes6 = $db->recettes->find(['_id' => ['$in' => $recettes6Ids]]);
    foreach ($recettes6 as $recette) {
        echo "- {$recette->nom} (difficulté: {$recette->difficulte})\n";
    }
} else {
    echo "Aucune recette trouvée pour le produit n°6.\n";
}

// 6) Fonction pour récupérer un produit par numéro et taille
function getProduitParTaille(int $numero, string $taille): array
{
    $db = MongoConnection::getDb();
    $prod = $db->produits->findOne(['numero' => $numero]);
    if (!$prod) return [];

    $tarifValue = null;
    if (!empty($prod->tarifs)) {
        foreach ($prod->tarifs as $tarif) {
            if (($tarif->taille ?? '') === $taille) {
                $tarifValue = $tarif->tarif ?? null;
                break;
            }
        }
    }

    return [
        'numero' => $prod->numero,
        'libelle' => $prod->libelle,
        'categorie' => $prod->categorie ?? 'Inconnue',
        'taille' => $taille,
        'tarif' => $tarifValue
    ];
}

echo "\n6) Produit n°6, taille 'normale', en JSON:\n";
$result = getProduitParTaille(6, 'normale');
echo json_encode($result, JSON_PRETTY_PRINT), "\n";