<?php

namespace LaChaudiere\webui\actions\Admin;

use LaChaudiere\core\application\services\UserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetAllUsersAction
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $users = $this->userService->getAllUsers();

        $response->getBody()->write(json_encode([
            'success' => true,
            'data' => $users
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}