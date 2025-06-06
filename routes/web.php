<?php

use LaChaudiere\webui\actions\HomePageAction;
use Slim\App;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use LaChaudiere\core\application\services\CategoryService;

return function (App $app) {
    // Page d'accueil avec les catégories
    $app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
        $categories = $this->get(CategoryService::class)->getAll();
        return $this->get('view')->render($response, 'pages/home.twig', [
            'categories' => $categories
        ]);
    })->setName('home');

    // Liste des catégories
    $app->get('/categories', function (ServerRequestInterface $request, ResponseInterface $response) {
        $categories = $this->get(CategoryService::class)->getAll();
        return $this->get('view')->render($response, 'pages/categories.twig', [
            'categories' => $categories
        ]);
    });

    // Formulaire d’ajout de catégorie
    $app->get('/categories/create', function (ServerRequestInterface $request, ResponseInterface $response) {
        return $this->get('view')->render($response, 'pages/categories_form.twig');
    });

    // Liste des événements
    $app->get('/events', function (ServerRequestInterface $request, ResponseInterface $response) {
        $repo = $this->get('event_repository');
        $events = $repo->findAll();
        return $this->get('view')->render($response, 'pages/events.twig', [
            'events' => $events
        ]);
    });

    // Traitement du formulaire d’ajout de catégorie
    $app->post('/categories/create', function (ServerRequestInterface $request, ResponseInterface $response) {
        $data = $request->getParsedBody();
        $name = trim($data['name'] ?? '');
        $description = trim($data['description'] ?? '');

        if ($name !== '') {
            $this->get(CategoryService::class)->createCategory($name, $description);
            // Redirection vers la liste des catégories
            return $response
                ->withHeader('Location', '/categories')
                ->withStatus(302);
        }

        // Si le nom est vide, on réaffiche le formulaire avec un message d’erreur
        return $this->get('view')->render($response, 'pages/categories_form.twig', [
            'error' => 'Le nom de la catégorie est requis.',
            'old' => ['name' => $name, 'description' => $description]
        ]);
    });
};