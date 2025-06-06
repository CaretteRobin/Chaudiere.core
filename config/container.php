<?php

use DI\Container;
use LaChaudiere\core\application\UseCase\Event\CreateEvent;
use LaChaudiere\core\application\UseCase\Event\DeleteEvent;
use LaChaudiere\core\application\UseCase\Event\GetAllEvent;
use LaChaudiere\core\application\UseCase\Event\GetEventById;
use LaChaudiere\core\application\UseCase\Event\GetEventByPeriodFilter;
use LaChaudiere\core\application\services\EventService;
use LaChaudiere\core\application\services\CategoryService;
use LaChaudiere\infra\persistence\Eloquent\EventRepository;
use LaChaudiere\core\application\interfaces\EventRepositoryInterface;
use LaChaudiere\core\application\interfaces\CategoryRepositoryInterface;
use LaChaudiere\infra\persistence\Eloquent\CategoryRepository;
use LaChaudiere\core\application\interfaces\UserRepositoryInterface;
use LaChaudiere\infra\persistence\Eloquent\UserRepository;
use Slim\Views\Twig;
use Twig\TwigFunction;

$container = new Container();

// Bind du repository
$container->set(EventRepositoryInterface::class, fn() => new EventRepository());
$container->set(CategoryRepositoryInterface::class, fn() => new CategoryRepository());
$container->set(UserRepositoryInterface::class, fn() => new UserRepository());

// Bind du service Twig pour les vues avec la fonction base_url
$container->set('view', function() {
    $twig = Twig::create(__DIR__ . '/../webui/Views', ['cache' => false]);
    $twig->getEnvironment()->addFunction(new TwigFunction('base_url', function($path = '') {
        // Retourne le chemin relatif, à adapter si besoin
        return $path ? '/' . ltrim($path, '/') : '/';
    }));
    return $twig;
});

// Bind du service catégorie
$container->set(CategoryService::class, fn() => new CategoryService(
    $container->get(CategoryRepositoryInterface::class)
));

// Bind des use cases
$container->set(GetAllEvent::class, fn() => new GetAllEvent($container->get(EventRepositoryInterface::class)));
$container->set(GetEventById::class, fn() => new GetEventById($container->get(EventRepositoryInterface::class)));
$container->set(CreateEvent::class, function () use ($container) {
    return new CreateEvent(
        $container->get(EventRepositoryInterface::class),
        $container->get(CategoryRepositoryInterface::class),
        $container->get(UserRepositoryInterface::class),
    );
});
$container->set(DeleteEvent::class, fn() => new DeleteEvent($container->get(EventRepositoryInterface::class)));
$container->set(GetEventByPeriodFilter::class, function () use ($container) {
    return new GetEventByPeriodFilter($container->get(EventRepositoryInterface::class));
});

// Bind du service event
$container->set(EventService::class, fn() => new EventService(
    $container->get(GetAllEvent::class),
    $container->get(GetEventById::class),
    $container->get(CreateEvent::class),
    $container->get(DeleteEvent::class),
    $container->get(GetEventByPeriodFilter::class),
));

return $container;