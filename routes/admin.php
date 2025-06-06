<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/admin', function (RouteCollectorProxy $group) {
        $group->get('/users', \LaChaudiere\webui\actions\Admin\GetAllUsersAction::class);

        $group->post('/users', \LaChaudiere\webui\actions\Admin\CreateUserAction::class);

        $group->delete('/users/{id}', \LaChaudiere\webui\actions\Admin\DeleteUserAction::class);

    });
};