<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Faker\Factory;

// Paramètres de connexion (adapte si besoin)
$host = 'chaudiere-db';
$db   = 'lachaudiere';
$user = 'chaudiere_user';
$pass = 'chaudiere_password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$faker = Factory::create('fr_FR');

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Récupérer les IDs valides
    $userIds = $pdo->query('SELECT id FROM users')->fetchAll(PDO::FETCH_COLUMN);
    $categoryIds = $pdo->query('SELECT id FROM categories')->fetchAll(PDO::FETCH_COLUMN);

    if (empty($userIds) || empty($categoryIds)) {
        die("Aucun utilisateur ou catégorie trouvés.\n");
    }

    // Générer 20 événements
    for ($i = 0; $i < 20; $i++) {
        $title = $faker->sentence(3);
        $description = $faker->paragraph;
        $price = $faker->randomFloat(2, 0, 100);
        $startDate = $faker->date('Y-m-d');
        $endDate = $faker->date('Y-m-d', $startDate);
        $categoryId = $faker->randomElement($categoryIds);
        $createdBy = $faker->randomElement($userIds);

        $stmt = $pdo->prepare('INSERT INTO events (title, description, price, start_date, end_date, category_id, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $title,
            $description,
            $price,
            $startDate,
            $endDate,
            $categoryId,
            $createdBy
        ]);
    }

    echo "20 événements générés avec succès.\n";
} catch (\PDOException $e) {
    echo "Erreur PDO : " . $e->getMessage() . "\n";
    exit(1);
}