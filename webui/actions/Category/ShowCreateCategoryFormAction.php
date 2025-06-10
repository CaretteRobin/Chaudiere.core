<?php

namespace LaChaudiere\webui\actions\Category;

use LaChaudiere\infra\providers\CsrfTokenProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ShowCreateCategoryFormAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        // Generate a CSRF token for the form
        $csrfToken = CsrfTokenProvider::generate();

        return $view->render($response, 'pages/categories_form.twig', [
            'csrf_token' => $csrfToken
        ]);
    }
}