<?php

namespace LaChaudiere\webui\actions\Event;

use LaChaudiere\core\application\services\EventService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class GetEventByIdAction
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = (string) $args['id'];

        $event = $this->eventService->getEventById($id);

        if (!$event) {
            throw new HttpNotFoundException($request, "Event not found");
        }

        $response->getBody()->write($event->toJson());
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
