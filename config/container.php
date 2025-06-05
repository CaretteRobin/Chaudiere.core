<?php

use DI\Container;
use LaChaudiere\core\application\interface\UserRepositoryInterface;
use LaChaudiere\infra\persistence\Eloquent\UserRepository;
use LaChaudiere\core\application\interface\EventRepositoryInterface;
use LaChaudiere\infra\persistence\Eloquent\EventRepository;

$container = new Container();

// Bind des interfaces vers les implémentations
$container->set(UserRepositoryInterface::class, fn() => new UserRepository());
$container->set(EventRepositoryInterface::class, fn() => new EventRepository());

// Tu peux binder aussi des services ou usecases manuellement si besoin

return $container;
