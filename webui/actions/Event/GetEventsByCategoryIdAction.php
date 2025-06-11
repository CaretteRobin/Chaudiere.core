<?php

namespace LaChaudiere\webui\actions\Event;

use LaChaudiere\core\application\services\EventService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class GetEventsByCategoryIdAction
{
    private EventService $eventService;

    /**
     * Constructeur de l'action
     *
     * @param EventService $eventService
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Exécute l'action pour récupérer les événements par catégorie
     *
     * @param Request $request La requête HTTP
     * @param Response $response La réponse HTTP
     * @param array $args Les arguments de la route
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        // Récupération de l'ID de la catégorie depuis les arguments de la route
        $categoryId = $args['id'] ?? null;

        // Vérification de la présence de l'ID de catégorie
        if (!$categoryId) {
            throw new HttpBadRequestException($request, "L'ID de la catégorie est requis");
        }

        // Récupération des événements via le service
        $events = $this->eventService->getEventsByCategory($categoryId);

        // Préparation et envoi de la réponse au format JSON
        $response->getBody()->write(json_encode([
            'success' => true,
            'data' => $events,
            'count' => count($events)
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}