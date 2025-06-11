<?php

namespace LaChaudiere\webui\actions\Event;

use LaChaudiere\core\application\services\CategoryService;
use LaChaudiere\core\application\services\EventService;
use LaChaudiere\infra\providers\CsrfTokenProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ListEventsAction
{
    private EventService $eventService;
    private CategoryService $categoryService;
    private Twig $view;

    public function __construct(EventService $eventService, CategoryService $categoryService, Twig $view)
    {
        $this->eventService = $eventService;
        $this->categoryService = $categoryService;
        $this->view = $view;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $queryParams = $request->getQueryParams();
        $categoryId = $queryParams['category'] ?? null;

        $categories = $this->categoryService->getAll();

        $events = $categoryId
            ? $this->eventService->getEventsByCategorySortedByDateAsc($categoryId)
            : $this->eventService->getAllEventsSortedByDateAsc();

        $csrf = CsrfTokenProvider::generate();
        $user = $request->getAttribute('user');

        return $view->render($response, 'events/list.twig', [
            'events' => $events,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'csrf_token' => $csrf,
            'user' => $user,
        ]);
    }
}
