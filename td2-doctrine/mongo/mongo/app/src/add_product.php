<?php
require_once 'MongoConnection.php';

$db = MongoConnection::getDb();

// Catégories possibles
$categories = ['Pizzas', 'Boissons', 'Salades', 'Desserts', 'Test'];

// Tailles possibles
$tailles = ['normale', 'grande', 'petite'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = (int)$_POST['numero'];
    $libelle = $_POST['libelle'];
    $description = $_POST['description'];
    $categorie = $_POST['categorie'];
    $tarifs = [];

    foreach ($tailles as $taille) {
        if (isset($_POST['tarif'][$taille]) && $_POST['tarif'][$taille] !== '') {
            $tarifs[] = [
                'taille' => $taille,
                'tarif' => (float)$_POST['tarif'][$taille]
            ];
        }
    }

    $db->produits->insertOne([
        'numero' => $numero,
        'libelle' => $libelle,
        'description' => $description,
        'categorie' => $categorie,
        'tarifs' => $tarifs,
        'recettes' => [] // vide par défaut
    ]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit</title>
</head>
<body>
<h1>Ajouter un produit</h1>

<form method="post" action="">
    <label>Numéro : <input type="number" name="numero" required></label><br>
    <label>Libellé : <input type="text" name="libelle" required></label><br>
    <label>Description : <input type="text" name="description"></label><br>
    <label>Catégorie :
        <select name="categorie" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>

    <fieldset>
        <legend>Tarifs :</legend>
        <?php foreach ($tailles as $taille): ?>
            <label><?= htmlspecialchars($taille) ?> :
                <input type="number" step="0.01" name="tarif[<?= $taille ?>]">
            </label><br>
        <?php endforeach; ?>
    </fieldset>

    <button type="submit">Ajouter</button>
</form>

<a href="index.php">Retour au catalogue</a>
</body>
</html>