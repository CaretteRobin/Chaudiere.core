<?php

declare(strict_types=1);

use Slim\App;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use LaChaudiere\webui\actions\Event\GetAllEventsAction;

return function (App $app): void {
    $app->get('/ping', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $response->getBody()->write(json_encode(['message' => 'pong']));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/events', GetAllEventsAction::class);
};
