<?php

use LaChaudiere\webui\actions\Admin\CreateUserAction;
use LaChaudiere\webui\actions\Admin\DeleteUserAction;
use LaChaudiere\webui\actions\Admin\GetAllUsersAction;
use LaChaudiere\webui\actions\Auth\LogoutAction;
use LaChaudiere\webui\actions\Auth\RegisterAction;
use LaChaudiere\webui\actions\Auth\LoginAction;
use LaChaudiere\webui\actions\Auth\ShowAuthPageAction;
use LaChaudiere\webui\actions\Category\GetCategoriesAction;
use LaChaudiere\webui\actions\Event\GetAllEventsAction;
use LaChaudiere\webui\actions\HomePageAction;
use LaChaudiere\webui\actions\Category\ShowCreateCategoryFormAction;
use LaChaudiere\webui\actions\Category\CreateCategoryAction;
use LaChaudiere\webui\middlewares\AuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {

    $app->get('/auth', ShowAuthPageAction::class)->setName('auth_page');
    $app->post('/login', LoginAction::class)->setName('auth_login');
    $app->post('/register', RegisterAction::class)->setName('auth_register');

    $app->group('', function (RouteCollectorProxy $group): void {

        $group->get('/logout', LogoutAction::class)->setName('logout');

        // Page d'accueil avec les catégories
        $group->get('/', HomePageAction::class)->setName('home');

        // Liste des catégories
        $group->get('/categories', GetCategoriesAction::class);

        // Formulaire d’ajout de catégorie
        $group->get('/categories/create', ShowCreateCategoryFormAction::class);

        // Traitement du formulaire d’ajout de catégorie
        $group->post('/categories/create', CreateCategoryAction::class);

        // Administration utilisateurs
        $group->get('/admin', GetAllUsersAction::class);
        $group->post('/admin/users/create', CreateUserAction::class);
        $group->get('/admin/users/delete/{id}', DeleteUserAction::class)->setName('delete_user');
        $group->get('/admin/users', GetAllUsersAction::class)->setName('admin_users');

        // Liste des événements
        $group->get('/events', GetAllEventsAction::class);

    })->add(AuthMiddleware::class);
};