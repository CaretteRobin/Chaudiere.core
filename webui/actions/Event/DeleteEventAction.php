<?php

namespace LaChaudiere\webui\actions\Event;

use LaChaudiere\core\application\services\EventService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class DeleteEventAction
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'] ?? null;
        if (!$id) {
            throw new HttpNotFoundException($request, "ID manquant");
        }

        $deleted = $this->eventService->deleteEvent($id);
        if (!$deleted) {
            throw new HttpNotFoundException($request, "Événement non trouvé");
        }

        $response->getBody()->write(json_encode([
            'success' => true,
            'message' => "Événement supprimé"
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}