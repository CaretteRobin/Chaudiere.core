<?php

use LaChaudiere\webui\actions\Event\GetSortedEventsAction;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

use LaChaudiere\webui\actions\Category\CreateCategoryAction;
use LaChaudiere\webui\actions\Category\DeleteCategoryAction;
use LaChaudiere\webui\actions\Category\GetCategoriesAction;
use LaChaudiere\webui\actions\Event\CreateEventAction;
use LaChaudiere\webui\actions\Event\DeleteEventAction;
use LaChaudiere\webui\actions\Event\GetAllEventsAction;
use LaChaudiere\webui\actions\Event\GetEventsByCategAction;
use LaChaudiere\webui\actions\Event\GetEventsByCategoryIdAction;
use LaChaudiere\webui\actions\Event\GetEventByIdAction;
use LaChaudiere\webui\actions\Event\UpdateEventAction;
use Psr\Http\Message\ServerRequestInterface;

return function (App $app) {
    $app->group('/api', function (RouteCollectorProxy $group) {

        // Routes pour les événements
        $group->group('/evenements', function (RouteCollectorProxy $group) {
            $group->get('', GetSortedEventsAction::class); // Tous les événements, avec filtre ?sort=...
            $group->get('/{id}', GetEventByIdAction::class);
        });

        // Routes pour les catégories
        $group->group('/categories', function (RouteCollectorProxy $group) {
            $group->get('/all', GetCategoriesAction::class);
            $group->get('/create/{id}', CreateCategoryAction::class);
            $group->get('/delete/{id}', DeleteCategoryAction::class);
            $group->get('/{id}', GetEventsByCategoryIdAction::class);
            $group->get('/{id}/evenements', GetEventsByCategAction::class);
        });

    });
};