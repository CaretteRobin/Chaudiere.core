<?php

use DI\Container;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

// 1. Charger le conteneur de dépendances
$container = require __DIR__ . '/../config/container.php';
AppFactory::setContainer($container);

// 2. Créer l'application Slim
$app = AppFactory::create();

// 3. Charger les routes
(require __DIR__ . '/../routes/routes.php')($app);

// 4. Retourner l'application
return $app;
