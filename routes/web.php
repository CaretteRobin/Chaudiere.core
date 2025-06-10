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


        $group->group('/admin', function (RouteCollectorProxy $group) {
            $group->get('/users', GetAllUsersAction::class);
            $group->post('/users', CreateUserAction::class);
            $group->delete('/users/{id}', DeleteUserAction::class);
        });


// Routes pour les événements
        $group->get('/evenements/create', CreateEventFormAction::class)->setName('events.create.form');
        $group->post('/evenements/create', HandleCreateEventAction::class)->setName('events.create.handle');
        $group->get('/evenements', ListEventsAction::class)->setName('evenements.list');
// Routes pour les catégories

$group->group('/categories', function (RouteCollectorProxy $group) {
    $group->get('', GetCategoriesAction::class); // Liste toutes les catégories
    $group->post('', CreateCategoryAction::class); // Crée une catégorie
    $group->get('/{id}', ShowCreateCategoryFormAction::class); // Détail d'une catégorie
    $group->delete('/{id}', DeleteCategoryAction::class); // Supprime une catégorie
});

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
