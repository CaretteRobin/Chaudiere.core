<?php
declare(strict_types=1);

namespace LaChaudiere\webui\actions\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use LaChaudiere\core\application\services\UserService;
use Slim\Views\Twig;

class GetAllUserAction
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $users = $this->userService->getAllUsers();

        $view = Twig::fromRequest($request);

                $user = $request->getAttribute('user');

        $params = [];

        if ($user) {
            $params['user'] = $user;
        }

        $params['users'] = $users;

        return $view->render($response, 'pages/user/show_users.twig', $params);
    }
}