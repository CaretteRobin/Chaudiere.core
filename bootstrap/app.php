<?php

use Slim\Factory\AppFactory;
use Dotenv\Dotenv;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\TwigFunction;

require_once __DIR__ . '/../vendor/autoload.php';

// Charger .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Configurer le container avec bindings
$container = require __DIR__ . '/../config/container.php';
AppFactory::setContainer($container);

// Créer l'application
$app = AppFactory::create();

// Ajouter le middleware pour parser les body JSON/form
$app->addBodyParsingMiddleware();

// Ajouter gestionnaire d’erreurs par défaut
$app->addErrorMiddleware(true, true, true);

// Charger Twig
// Création de l’instance Twig
$twig = Twig::create(__DIR__ . '/../webui/Views', ['cache' => false]);

// Ajout du middleware Twig à l’application Slim
$app->add(TwigMiddleware::create($app, $twig));
$twig->getEnvironment()->addFunction(new TwigFunction('base_url', static function () {
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
    return $scriptDir === '/' ? '' : $scriptDir;
}));

// Charger les routes
(require __DIR__ . '/../routes/web.php')($app);
(require __DIR__ . '/../routes/api.php')($app);

// Retourner l’application configurée
return $app;
