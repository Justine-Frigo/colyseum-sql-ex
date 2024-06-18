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

// Requête SQL pour sélectionner tous les clients
$sql = "SELECT * FROM clients";
$stmt = $pdo->query($sql);

// 20 premiers clients
// $sql = "SELECT * FROM clients LIMIT 20";

// Carte de fidélité
// $sqlCards = "SELECT c.id, c.lastName, c.firstName, c.birthDate, c.cardNumber
// FROM clients c
// JOIN cards ca ON c.cardNumber = ca.cardNumber
// WHERE ca.cardTypesId = 1;";

// Récupérer tous les résultats
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
// $stmtCards = $pdo->query($sqlCards);
// $clients_with_loyalty = $stmtCards->fetchAll(PDO::FETCH_ASSOC);

// print_r($clients_with_loyalty);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des clients</title>
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
    <h1>Liste des clients</h1>
    <table>
        <thead>
            <tr>
                <!-- <th>ID</th> -->
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de naissance</th>
                <th>Carte</th>
                <th>Numéro de carte</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client) : ?>
                <tr>
                <!-- <td><?= htmlspecialchars($client['id'] ?? '') ?></td> -->
                    <td><?= htmlspecialchars($client['lastName'] ?? '') ?></td>
                    <td><?= htmlspecialchars($client['firstName'] ?? '') ?></td>
                    <td><?= htmlspecialchars($client['birthDate'] ?? '') ?></td>
                    <td><?= htmlspecialchars($client['card'] == 1 ? 'oui' : 'non') ?></td>
                    <td><?= htmlspecialchars($client['cardNumber'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
