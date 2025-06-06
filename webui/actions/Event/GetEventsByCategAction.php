<?php

namespace LaChaudiere\webui\actions\Event;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use LaChaudiere\core\application\services\EventService;

class GetEventsByCategAction
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $categoryId = (int) $args['id'];
        $events = $this->eventService->getEventsByCategory($categoryId);

        $response->getBody()->write(json_encode($events));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
