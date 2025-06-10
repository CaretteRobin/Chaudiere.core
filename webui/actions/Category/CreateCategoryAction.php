<?php

namespace LaChaudiere\webui\actions\Category;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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

        $categoryData = [
            'id' => Str::uuid()->toString(),
            'name' => $name
        ];

        if ($name !== '') {
            $this->categoryService->create($categoryData);

            return $this->redirectWithFlash(
                $response,
                '',
                'La catégorie a été créée avec succès.',
                'success'
            );

        }

        return $this->redirectWithFlash(
            $response,
            '',
            'Le nom de la catégorie ne peut pas être vide.',
            'error'
        );
    }
}