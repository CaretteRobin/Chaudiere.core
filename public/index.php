<?php

// Bootstrapping de l'application
$app = require __DIR__ . '/../bootstrap/app.php';
$app->add(\Slim\Views\TwigMiddleware::createFromContainer($app));
// Lancer Slim
$app->run();
