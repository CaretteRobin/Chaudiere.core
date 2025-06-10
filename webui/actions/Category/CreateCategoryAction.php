<?php

namespace LaChaudiere\webui\actions\Category;

use LaChaudiere\core\application\services\CategoryService;
use LaChaudiere\infra\providers\CsrfTokenProvider;
use LaChaudiere\webui\traits\FlashRedirectTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class CreateCategoryAction
{
    use FlashRedirectTrait;
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
//        $view = Twig::fromRequest($request);
        $data = $request->getParsedBody();
        $name = trim($data['name'] ?? '');
        $description = trim($data['description'] ?? '');

        if ($name !== '') {
            $this->categoryService->createCategory($name, $description);

            return $this->redirectWithFlash(
                $response,
                'categories',
                'La catégorie a été créée avec succès.',
                'success'
            );

        }

        return $this->redirectWithFlash(
            $response,
            'categories',
            'Le nom de la catégorie ne peut pas être vide.',
            'error'
        );
    }
}