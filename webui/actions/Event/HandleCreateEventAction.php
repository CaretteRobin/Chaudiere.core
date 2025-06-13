<?php

namespace LaChaudiere\webui\actions\Event;

use LaChaudiere\core\application\services\EventService;
use LaChaudiere\core\application\services\ImageService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class HandleCreateEventAction
{
    private EventService $eventService;
    private ImageService $imageService;

    public function __construct(EventService $eventService, ImageService $imageService)
    {
        $this->eventService = $eventService;
        $this->imageService = $imageService;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $user = $request->getAttribute('user');

        if (!$user) {
            $response->getBody()->write('Utilisateur non authentifié.');
            return $response->withStatus(401);
        }

        // Nettoyage & validation des données
        $title = trim(filter_var($data['title'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $description = trim($data['description'] ?? ''); // Markdown autorisé
        $price = isset($data['price']) && is_numeric($data['price']) ? (float)$data['price'] : 0.00;
        $startDate = !empty($data['start_date']) ? $data['start_date'] : null;
        $endDate = !empty($data['end_date']) ? $data['end_date'] : null;
        $time = !empty($data['time']) ? $data['time'] : null;
        $categoryId = isset($data['category_id']) ? trim($data['category_id']) : null;
        $imageUrl = !empty($data['image_url']) ? filter_var(trim($data['image_url']), FILTER_VALIDATE_URL) : null;

        // Création de l'événement
        $eventData = [
            'title'        => $title,
            'description'  => $description,
            'price'        => $price,
            'start_date'   => $startDate,
            'end_date'     => $endDate,
            'time'         => $time,
            'category_id'  => $categoryId,
            'created_by'   => $user->id,
            'is_published' => false,
        ];

        $event = $this->eventService->createEvent($eventData);

        // Ajout de l’image si fournie et valide
        if ($imageUrl) {
            $this->imageService->addImage($event->id, $imageUrl);
        }

        // Redirection vers la liste des événements
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response
            ->withHeader('Location', $routeParser->urlFor('event.list'))
            ->withStatus(302);
    }
}
