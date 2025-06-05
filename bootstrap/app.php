<?php

use Slim\Factory\AppFactory;
use Dotenv\Dotenv;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\TwigFunction;

require_once __DIR__ . '/../vendor/autoload.php';

// 1. Charger .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad(); // safeLoad() évite les erreurs si le fichier n'existe pas

// 2. Initialiser Eloquent ORM (capsule)
require_once __DIR__ . '/../infra/db/EloquentBootstrap.php';

// 2. Configurer le container avec bindings
$container = require __DIR__ . '/../config/container.php';
AppFactory::setContainer($container);

// 3. Créer l'application
$app = AppFactory::create();

// 4. Ajouter le middleware pour parser les body JSON/form
$app->addBodyParsingMiddleware();

// 5. Ajouter gestionnaire d’erreurs par défaut
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

// 6. Charger les routes
$webRoutes = __DIR__ . '/../routes/web.php';
$apiRoutes = __DIR__ . '/../routes/api.php';

if (file_exists($webRoutes)) {
    (require $webRoutes)($app);
}

if (file_exists($apiRoutes)) {
    (require $apiRoutes)($app);
}

// 7. Retourner l’application configurée
return $app;
