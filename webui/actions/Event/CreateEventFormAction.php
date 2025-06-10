<?php

namespace LaChaudiere\webui\actions\Event;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use LaChaudiere\core\application\services\CategoryService;
use LaChaudiere\infra\providers\CsrfTokenProvider;

class CreateEventFormAction
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $view = Twig::fromRequest($request);

        $csrf = CsrfTokenProvider::generate();

        $categories = $this->categoryService->getAll();


        return $view->render($response, 'events/create.twig', [
            'categories' => $categories,
            'csrf_token' => $csrf,
        ]);
    }
}
