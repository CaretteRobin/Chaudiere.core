<?php

use LaChaudiere\webui\actions\Event\GetAllEventsAction;
use LaChaudiere\webui\actions\Event\GetEventsByCategoryAction;
use LaChaudiere\webui\actions\Event\GetEventByIdAction;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Psr\Http\Message\ResponseInterface; 
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api', function (RouteCollectorProxy $group) {

        $group->group('/events', function (RouteCollectorProxy $group) {
            $group->post('', \LaChaudiere\webui\actions\Event\CreateEventAction::class);
            $group->get('', GetAllEventsAction::class);
            $group->get('/{id}', GetEventByIdAction::class);
            $group->get('/category/{categoryId}', GetEventsByCategoryAction::class);
            $group->put('/{id}', \LaChaudiere\webui\actions\Event\UpdateEventAction::class);
            $group->delete('/{id}', \LaChaudiere\webui\actions\Event\DeleteEventAction::class);
        });

    });
};