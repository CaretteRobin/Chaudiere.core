<?php

use LaChaudiere\webui\actions\Event\GetAllEventsAction;
use LaChaudiere\webui\actions\Event\GetEventsByCategoryAction;
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

        $group->group('/events', function (RouteCollectorProxy $group) {
            $group->get('', GetAllEventsAction::class);
            $group->get('/{id}', GetEventByIdAction::class);
            $group->get('/category/{categoryId}', GetEventsByCategoryAction::class);
        });

    });
};