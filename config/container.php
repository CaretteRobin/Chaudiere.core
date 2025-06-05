<?php

declare(strict_types=1);

use DI\Container;
use LaChaudiere\core\application\interface\UserRepositoryInterface;
use LaChaudiere\infra\persistence\Eloquent\UserRepository;
use LaChaudiere\core\application\interface\EventRepositoryInterface;
use LaChaudiere\infra\persistence\Eloquent\EventRepository;
use LaChaudiere\core\application\services\EventService;
use LaChaudiere\core\application\services\UserService;

$container = new Container();

// Bind des repositories
$container->set(UserRepositoryInterface::class, fn() => new UserRepository());
$container->set(EventRepositoryInterface::class, fn() => new EventRepository());

$container->set(EventService::class, function () use ($container) {
    return new EventService($container->get(EventRepositoryInterface::class));
});

return $container;
