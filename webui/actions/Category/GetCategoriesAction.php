<?php

declare(strict_types=1);

namespace LaChaudiere\webui\actions\Category;

use LaChaudiere\core\application\services\CategoryService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetCategoriesAction
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $categories = $this->categoryService->getAll();

        $response->getBody()->write(json_encode([
            'success' => true,
            'data' => $categories,
            'count' => count($categories)
        ]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}