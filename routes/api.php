<?php

use LaChaudiere\webui\actions\Category\CreateCategoryAction;
use LaChaudiere\webui\actions\Category\DeleteCategoryAction;
use LaChaudiere\webui\actions\Category\GetCategoriesAction;
use LaChaudiere\webui\actions\Event\CreateEventAction;
use LaChaudiere\webui\actions\Event\DeleteEventAction;
use LaChaudiere\webui\actions\Event\GetAllEventsAction;
use LaChaudiere\webui\actions\Event\GetEventsByCategoryAction;
use LaChaudiere\webui\actions\Event\GetEventByIdAction;
use LaChaudiere\webui\actions\Event\UpdateEventAction;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api', function (RouteCollectorProxy $group) {

        $group->group('/evenements', function (RouteCollectorProxy $group) {
            $group->post('', CreateEventAction::class);
            $group->get('', GetAllEventsAction::class);
            $group->get('/{id}', GetEventByIdAction::class);
            $group->put('/{id}', UpdateEventAction::class);
            $group->delete('/{id}', DeleteEventAction::class);
            $group->get('/category/{categoryId}', GetEventsByCategoryAction::class);
        });
        $group->group('/categories', function (RouteCollectorProxy $group) {
            $group->get('/all', GetCategoriesAction::class);
            $group->get('/create/{id}', CreateCategoryAction::class);
            $group->get('/delete/{id}', DeleteCategoryAction::class);
        });

    });
};