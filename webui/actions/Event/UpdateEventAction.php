<?php

namespace LaChaudiere\webui\actions\Event;

use LaChaudiere\core\application\services\EventService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class UpdateEventAction
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
            throw new HttpBadRequestException($request, "ID manquant");
        }

        $data = json_decode((string)$request->getBody(), true);
        if (empty($data)) {
            throw new HttpBadRequestException($request, "Données manquantes");
        }

        $event = $this->eventService->updateEvent($id, $data);
        if (!$event) {
            throw new HttpNotFoundException($request, "Événement non trouvé");
        }

        $response->getBody()->write(json_encode([
            'success' => true,
            'data' => $event
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}