<?php

use LaChaudiere\webui\actions\Category\CreateCategoryAction;
use LaChaudiere\webui\actions\Category\DeleteCategoryAction;
use LaChaudiere\webui\actions\Category\GetCategoriesAction;
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
            $group->get('', GetAllEventsAction::class);
            $group->get('/{name}', GetEventByIdAction::class);
            $group->get('/category/{categoryId}', GetEventsByCategoryAction::class);
        });
        $group->group('/categories', function (RouteCollectorProxy $group) {
            $group->get('/all', GetCategoriesAction::class);
            $group->get('/create/{id}', CreateCategoryAction::class);
            $group->get('/delete/{id}', DeleteCategoryAction::class);
        });

    });
};