<?php

declare(strict_types=1);

use DI\Container;
use LaChaudiere\core\application\interfaces\AuthnServiceInterface;
use LaChaudiere\core\application\interfaces\CategoryRepositoryInterface;
use LaChaudiere\core\application\interfaces\EventRepositoryInterface;
use LaChaudiere\core\application\interfaces\UserRepositoryInterface;
use LaChaudiere\core\application\services\AuthnService;
use LaChaudiere\core\application\services\CategoryService;
use LaChaudiere\core\application\services\EventService;
use LaChaudiere\core\application\UseCase\Category\CreateCategory;
use LaChaudiere\core\application\UseCase\Category\DeleteCategory;
use LaChaudiere\core\application\UseCase\Category\GetAllCategories;
use LaChaudiere\core\application\UseCase\Category\GetCategoryById;
use LaChaudiere\core\application\UseCase\Category\UpdateCategory;
use LaChaudiere\core\application\UseCase\Event\DeleteEvent;
use LaChaudiere\core\application\UseCase\Event\GetAllEvent;
use LaChaudiere\core\Application\UseCase\Event\GetEventById;
use LaChaudiere\core\application\UseCase\Event\GetEventByPeriodFilter;
use LaChaudiere\core\application\UseCase\Event\GetEventsByCategory;
use LaChaudiere\infra\persistence\Eloquent\CategoryRepository;
use LaChaudiere\infra\persistence\Eloquent\EventRepository;
use LaChaudiere\infra\persistence\Eloquent\UserRepository;
use LaChaudiere\infra\providers\AuthProvider;
use LaChaudiere\infra\providers\interfaces\AuthProviderInterface;
use LaChaudiere\core\application\UseCase\Event\CreateEvent;

$container = new Container(); 

// Bind du repository
$container->set(EventRepositoryInterface::class, fn() => new EventRepository());
$container->set(CategoryRepositoryInterface::class, fn() => new CategoryRepository());
$container->set(UserRepositoryInterface::class, fn() => new UserRepository());
$container->set(EventRepositoryInterface::class, fn() => new EventRepository());

// Bind des services
$container->set(AuthProviderInterface::class, function (Container $container) {
    return new AuthProvider(
        $container->get(AuthnServiceInterface::class)
    );
});
$container->set(AuthnServiceInterface::class, fn () => new AuthnService());
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
    $container->get(GetEventsByCategory::class)

));

$container->set(CategoryService::class, fn() => new CategoryService(
    $container->get(CategoryRepositoryInterface::class),
    $container->get(CreateCategory::class),
    $container->get(DeleteCategory::class),
    $container->get(UpdateCategory::class),
    $container->get(GetAllCategories::class),
    $container->get(GetCategoryById::class),

));




return $container;