<?php

namespace LaChaudiere\webui\actions\Event;

use LaChaudiere\core\application\services\EventService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class CreateEventAction
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = json_decode((string)$request->getBody(), true);

        // Vérification des champs requis (exemple : name, category_id, date)
        if (empty($data['name']) || empty($data['category_id']) || empty($data['date'])) {
            throw new HttpBadRequestException($request, "Champs requis manquants");
        }

        // Création de l’événement via le service
        $event = $this->eventService->createEvent($data);

        $response->getBody()->write(json_encode([
            'success' => true,
            'data' => $event
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}