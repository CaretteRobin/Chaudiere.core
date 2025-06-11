<?php

use LaChaudiere\webui\actions\Category\GetCategoryByIdAction;
use LaChaudiere\webui\actions\Event\GetSortedEventsAction;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

use LaChaudiere\webui\actions\Category\GetAllCategoryAction;
use LaChaudiere\webui\actions\Event\GetEventsByCategoryIdAction;
use LaChaudiere\webui\actions\Event\GetEventByIdAction;

return function (App $app) {
    $app->group('/api', function (RouteCollectorProxy $group) {

        // Routes pour les événements
        $group->group('/evenements', function (RouteCollectorProxy $group) {
            $group->get('', GetSortedEventsAction::class); // Tous les événements, avec filtre ?sort=...
            $group->get('/{id}', GetEventByIdAction::class);
        });

        // Routes pour les catégories
        $group->group('/categories', function (RouteCollectorProxy $group) {
            $group->get('', GetAllCategoryAction::class);
            $group->get('/{id}', GetCategoryByIdAction::class);
            $group->get('/{id}/evenements', GetEventsByCategoryIdAction::class);
        });

    });
};