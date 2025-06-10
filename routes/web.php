<?php

use LaChaudiere\webui\actions\Auth\LogoutAction;
use LaChaudiere\webui\actions\Auth\RegisterAction;
use LaChaudiere\webui\actions\Auth\LoginAction;
use LaChaudiere\webui\actions\Auth\ShowAuthPageAction;
use LaChaudiere\webui\actions\Auth\ShowRegisterPageAction;
use LaChaudiere\webui\actions\Auth\GetAllUserAction;
use LaChaudiere\webui\actions\Auth\GetUserAction;
use LaChaudiere\webui\actions\Auth\UpdateUserAction;
use LaChaudiere\webui\actions\Auth\DeleteUserAction;
use LaChaudiere\webui\actions\HomePageAction;
use LaChaudiere\webui\actions\Event\CreateEventFormAction;
use LaChaudiere\webui\actions\Event\HandleCreateEventAction;
use LaChaudiere\webui\actions\Event\ListEventsAction;
use LaChaudiere\webui\middlewares\AuthMiddleware;
use LaChaudiere\webui\middlewares\AuthzMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {

    $app->get('/auth', ShowAuthPageAction::class)->setName('auth_page');
    $app->post('/login', LoginAction::class)->setName('auth_login');
    $app->group('', function (RouteCollectorProxy $group): void {
        $group->group('/register', function (RouteCollectorProxy $group): void {
            $group->post('', RegisterAction::class)->setName('auth_register');
            $group->get('', ShowRegisterPageAction::class)->setName('auth_register_page');
        })->add(AuthzMiddleware::class);
        $group->group('', function (RouteCollectorProxy $group): void {
            $group->get('/users', GetAllUserAction::class)->setName('show_users');
            $group->get('/users/{id}', GetUserAction::class)->setName('show_user');
            $group->post('/users/{id}', UpdateUserAction::class)->setName('update_user');
            $group->post('/users/{id}/delete', DeleteUserAction::class)->setName('delete_user');
        })->add(AuthzMiddleware::class);
        $group->get('/', HomePageAction::class)->setName('home');
        $group->get('/logout', LogoutAction::class)->setName('logout');
        $group->get('/evenements/create', CreateEventFormAction::class)->setName('events.create.form');
        $group->post('/evenements/create', HandleCreateEventAction::class)->setName('events.create.handle');
        $group->get('/evenements', ListEventsAction::class)->setName('evenements.list');

    })->add(AuthMiddleware::class);
};
