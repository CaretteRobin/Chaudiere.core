<?php
declare(strict_types=1);

namespace LaChaudiere\webui\actions\Auth;

use LaChaudiere\infra\providers\CsrfTokenProvider;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class ShowRegisterPageAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        $view = Twig::fromRequest($request);

        $csrfToken = CsrfTokenProvider::generate();

        return $view->render($response, 'pages/user/register.twig', [
            'csrf_token' => $csrfToken
        ]);
    }
}