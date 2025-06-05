<?php

use LaChaudiere\webui\actions\Event\GetAllEventsAction;
use LaChaudiere\webui\actions\Event\GetEventByIdAction;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Http\Interfaces\ResponseInterface;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->get('/ping', function (ServerRequestInterface $request, ResponseInterface $response) {
            $response->getBody()->write(json_encode(['message' => 'pong']));
            return $response->withHeader('Content-Type', 'application/json');
        });

        $group->get('/events', GetAllEventsAction::class);
        $group->get('/events/{id}',GetEventByIdAction::class);
    });
};