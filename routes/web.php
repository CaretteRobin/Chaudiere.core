<?php

use LaChaudiere\webui\actions\Admin\CreateUserAction;
use LaChaudiere\webui\actions\Admin\DeleteUserAction;
use LaChaudiere\webui\actions\Admin\GetAllUsersAction;
use LaChaudiere\webui\actions\Auth\LogoutAction;
use LaChaudiere\webui\actions\Auth\RegisterAction;
use LaChaudiere\webui\actions\Auth\LoginAction;
use LaChaudiere\webui\actions\Auth\ShowAuthPageAction;
use LaChaudiere\webui\actions\HomePageAction;
use LaChaudiere\webui\actions\Event\CreateEventFormAction;
use LaChaudiere\webui\actions\Event\HandleCreateEventAction;
use LaChaudiere\webui\actions\Event\ListEventsAction;
use LaChaudiere\webui\middlewares\AuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {

    $app->get('/auth', ShowAuthPageAction::class)->setName('auth_page');
    $app->post('/login', LoginAction::class)->setName('auth_login');
    $app->post('/register', RegisterAction::class)->setName('auth_register');

    $app->group('', function (RouteCollectorProxy $group): void {

        $group->get('/', HomePageAction::class)->setName('home');
        $group->get('/logout', LogoutAction::class)->setName('logout');


        $group->group('/admin', function (RouteCollectorProxy $group) {
            $group->get('/users', GetAllUsersAction::class);
            $group->post('/users', CreateUserAction::class);
            $group->delete('/users/{id}', DeleteUserAction::class);
        });

        $group->get('/evenements/create', CreateEventFormAction::class)->setName('events.create.form');
        $group->post('/evenements/create', HandleCreateEventAction::class)->setName('events.create.handle');
        $group->get('/evenements', ListEventsAction::class)->setName('evenements.list');

    })->add(AuthMiddleware::class);

};
