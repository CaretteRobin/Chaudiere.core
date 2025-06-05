<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return function (App $app) {
    $app->get('/ping', function (ServerRequestInterface $request, ResponseInterface $response) {
        $response->getBody()->write(json_encode(['message' => 'pong']));
        return $response->withHeader('Content-Type', 'application/json');
    });
};
