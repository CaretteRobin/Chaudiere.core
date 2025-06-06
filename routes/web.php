<?php

use LaChaudiere\webui\actions\Admin\CreateUserAction;
use LaChaudiere\webui\actions\Admin\DeleteUserAction;
use LaChaudiere\webui\actions\Admin\GetAllUsersAction;
use LaChaudiere\webui\actions\Auth\LogoutAction;
use LaChaudiere\webui\actions\Auth\RegisterAction;
use LaChaudiere\webui\actions\Auth\LoginAction;
use LaChaudiere\webui\actions\Auth\ShowAuthPageAction;
use LaChaudiere\webui\actions\Auth\ShowRegisterPageAction;
use LaChaudiere\webui\actions\Auth\GetAllUserAction;
use LaChaudiere\webui\actions\Auth\GetUserAction;
use LaChaudiere\webui\actions\Auth\UpdateUserAction;
use LaChaudiere\webui\actions\HomePageAction;
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
        })->add(AuthzMiddleware::class);
        $group->get('/', HomePageAction::class)->setName('home');
        $group->get('/logout', LogoutAction::class)->setName('logout');
    })->add(AuthMiddleware::class);
};
