<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return function (App $app) {
    $app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
        return $response->withStatus(418)
                        ->withHeader('Content-Type', 'text/plain')
                        ->getBody()->write("I'm a teapot");
    });
};
