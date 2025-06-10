<?php
declare(strict_types=1);

namespace LaChaudiere\webui\actions\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use LaChaudiere\core\application\services\UserService;
use Slim\Views\Twig;
use LaChaudiere\infra\providers\CsrfTokenProvider;

class GetUserAction
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $userId = (String)$args['id'];
        $userSpect = $this->userService->getUserById($userId);
        $csrfToken = CsrfTokenProvider::generate();

        $view = Twig::fromRequest($request);

        $user = $request->getAttribute('user');

        $params = [];

        if ($user) {
            $params['user'] = $user;
        }

        $params['userSpect'] = $userSpect;
        $params['csrf_token'] = $csrfToken;
        return $view->render($response, 'pages/user/user.twig', $params);
    }
}