<?php
require_once 'MongoConnection.php';

$db = MongoConnection::getDb();

$categories = $db->produits->distinct('categorie');

$selectedCategory = $_GET['categorie'] ?? '';

$query = [];
if ($selectedCategory) {
    $query['categorie'] = $selectedCategory;
}

$produits = $db->produits->find($query, ['sort' => ['numero' => 1]]);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Catalogue de produits</title>
</head>
<body>
<h1>Catalogue de produits</h1>

<form method="get" action="">
    <label for="categorie">Filtrer par catégorie :</label>
    <select name="categorie" id="categorie" onchange="this.form.submit()">
        <option value="">Toutes</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>" <?= $cat === $selectedCategory ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<hr>

<?php foreach ($produits as $prod): ?>
    <div style="margin-bottom:20px;">
        <strong><?= $prod->numero ?> - <?= htmlspecialchars($prod->libelle) ?></strong><br>
        Catégorie: <?= htmlspecialchars($prod->categorie) ?><br>
        Description: <?= htmlspecialchars($prod->description) ?><br>
        Tarifs:
        <ul>
            <?php foreach ($prod->tarifs ?? [] as $tarif): ?>
                <li><?= htmlspecialchars($tarif->taille) ?> : <?= $tarif->tarif ?> €</li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endforeach; ?>

<a href="add_product.php">Ajouter un produit</a>
</body>
</html>