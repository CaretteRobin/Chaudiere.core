<?php

namespace LaChaudiere\webui\actions\Category;

use LaChaudiere\infra\providers\CsrfTokenProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Parsedown;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ShowCreateCategoryFormAction
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws \Exception
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        $csrfToken = CsrfTokenProvider::generate();
        $user = $request->getAttribute('user');
        $params = [];

        if ($user) {
            $params['user'] = $user;
        }

        $params['csrf_token'] = $csrfToken;

        // Récupère les anciennes valeurs du formulaire (si présentes)
        $old = $request->getParsedBody() ?? [];
        $params['old'] = $old;

        // Aperçu Markdown -> HTML
        $descriptionMarkdown = $old['description'] ?? '';
        $params['descriptionHtml'] = '';
        if (!empty($descriptionMarkdown)) {
            $parsedown = new Parsedown();
            $params['descriptionHtml'] = $parsedown->text($descriptionMarkdown);
        }

        return $view->render($response, 'pages/categories_form.twig', $params);
    }
}