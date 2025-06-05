<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;

// Charger les variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->safeLoad();

// Charger la configuration de la base de données
$config = require __DIR__ . '/../../config/db.config.php';

// Vérifie que la clé 'driver' est bien définie
if (empty($config['driver'])) {
    throw new InvalidArgumentException('Le driver de base de données est manquant dans la configuration.');
}

// Configuration d'Eloquent ORM
$capsule = new Capsule();
$capsule->addConnection($config);
$capsule->setAsGlobal();
$capsule->bootEloquent();
