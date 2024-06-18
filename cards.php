<?php
use Dotenv\Dotenv;

require './vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Connexion à la base de données
try {
    $url = "mysql:host=" . $_ENV["DB_HOST"] . ";dbname=" . $_ENV["DB_NAME"] . ";charset=utf8";
    $pdo = new PDO($url, $_ENV["DB_USER"], $_ENV["DB_PASS"]);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Requête SQL pour sélectionner toutes les cartes
$sql = "SELECT * FROM cards";
$stmt = $pdo->query($sql);

// Récupérer tous les résultats
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des cartes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Liste des cartes</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Card number</th>
                <th>Card types Id</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cards as $card) : ?>
                <tr>
                    <td><?= htmlspecialchars($card['id'] ?? '') ?></td>
                    <td><?= htmlspecialchars($card['cardNumber'] ?? '') ?></td>
                    <td><?= htmlspecialchars($card['cardTypesId'] ?? '')?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
