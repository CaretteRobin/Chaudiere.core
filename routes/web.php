<?php

use LaChaudiere\webui\actions\Admin\DeleteUserAction;
use LaChaudiere\webui\actions\Admin\GetAllUsersAction;
use LaChaudiere\webui\actions\Auth\GetAllUserAction;
use LaChaudiere\webui\actions\Auth\GetUserAction;
use LaChaudiere\webui\actions\Auth\LogoutAction;
use LaChaudiere\webui\actions\Auth\RegisterAction;
use LaChaudiere\webui\actions\Auth\LoginAction;
use LaChaudiere\webui\actions\Auth\ShowAuthPageAction;
use LaChaudiere\webui\actions\Auth\ShowRegisterPageAction;
use LaChaudiere\webui\actions\Auth\UpdateUserAction;
use LaChaudiere\webui\actions\Event\ListEventAction;
use LaChaudiere\webui\actions\Category\CreateCategoryAction;
use LaChaudiere\webui\actions\Category\DeleteCategoryAction;
use LaChaudiere\webui\actions\Category\GetCategoriesAction;
use LaChaudiere\webui\actions\Category\ShowCreateCategoryFormAction;
use LaChaudiere\webui\actions\HomePageAction;
use LaChaudiere\webui\actions\Event\CreateEventFormAction;
use LaChaudiere\webui\actions\Event\HandleCreateEventAction;
use LaChaudiere\webui\actions\Event\ListEventsAction;
use LaChaudiere\webui\middlewares\AuthMiddleware;
use LaChaudiere\webui\middlewares\AuthzMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Routes publiques
    $app->get('/auth', ShowAuthPageAction::class)->setName('auth_page');
    $app->post('/login', LoginAction::class)->setName('auth_login');

    // Routes protégées par authentification
    $app->group('', function (RouteCollectorProxy $group) {
        // Route accueil
        $group->get('/', HomePageAction::class)->setName('home');

        // Routes d'authentification
        $group->get('/logout', LogoutAction::class)->setName('logout');
        $group->group('/register', function (RouteCollectorProxy $group) {
            $group->get('', ShowRegisterPageAction::class)->setName('auth_register_page');
            $group->post('', RegisterAction::class)->setName('auth_register');
        });

        // Routes événements
        $group->group('/evenements', function (RouteCollectorProxy $group) {
            $group->get('', ListEventsAction::class)->setName('event.list');
            $group->get('/events[/{categoryId}]', ListEventsAction::class)->setName('event.list');
            $group->get('/create', CreateEventFormAction::class)->setName('events.create.form');
            $group->post('/create', HandleCreateEventAction::class)->setName('events.create.handle');
            $group->get('/{categoryId}', ListEventsAction::class)->setName('event.list');
        });

        // Routes catégories
        $group->group('/categories', function (RouteCollectorProxy $group) {
            $group->get('', GetCategoriesAction::class);
            $group->get('/create', ShowCreateCategoryFormAction::class);
            $group->post('/create', CreateCategoryAction::class);
            $group->delete('/{id}', DeleteCategoryAction::class);
        });

        // Routes utilisateurs
        $group->group('/users', function (RouteCollectorProxy $group) {
            $group->get('', GetAllUserAction::class)->setName('show_users');
            $group->get('/{id}', GetUserAction::class)->setName('show_user');
            $group->post('/{id}', UpdateUserAction::class)->setName('update_user');
            $group->post('/{id}/delete', DeleteUserAction::class)->setName('delete_user');
        })->add(AuthzMiddleware::class);

    })->add(AuthMiddleware::class);
};