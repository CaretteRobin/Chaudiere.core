<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;
use App\Entity\Category;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.config.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

// Route de test
$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write('🎉 Slim fonctionne correctement !');
    return $response;
});

// Route API : /api/categories
$app->get('/api/categories', function (ServerRequestInterface $request, ResponseInterface $response) {
    $categories = Category::all();
    $response->getBody()->write(json_encode($categories));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
