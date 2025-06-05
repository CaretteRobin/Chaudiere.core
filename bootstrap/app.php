<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Middleware\BodyParsingMiddleware;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

// 1. Charger .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// 2. Configurer le container avec bindings
$container = require __DIR__ . '/../config/container.php';
AppFactory::setContainer($container);

// 3. Créer l'application
$app = AppFactory::create();

// 4. Ajouter le middleware pour parser les body JSON/form
$app->addBodyParsingMiddleware();

// 5. Ajouter gestionnaire d’erreurs par défaut
$app->addErrorMiddleware(true, true, true);

// 6. Charger les routes
(require __DIR__ . '/../routes/routes.php')($app);

// 7. Retourner l’application configurée
return $app;
