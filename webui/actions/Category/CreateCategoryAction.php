<?php

declare(strict_types=1);

namespace LaChaudiere\webui\actions\Category;

use LaChaudiere\core\application\services\CategoryService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class CreateCategoryAction
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        if (!isset($data['name']) || empty($data['name'])) {
            throw new HttpBadRequestException($request, "Le nom de la catégorie est requis");
        }

        $category = $this->categoryService->create($data);

        $response->getBody()->write(json_encode([
            'success' => true,
            'data' => $category
        ]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}