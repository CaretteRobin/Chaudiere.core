<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$config = require __DIR__ . '/../../config/db.config.php';

$capsule = new Capsule();
$capsule->addConnection($config);
$capsule->setAsGlobal();
$capsule->bootEloquent();
