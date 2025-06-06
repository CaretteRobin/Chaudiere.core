<?php

namespace LaChaudiere\webui\actions\Admin;

use LaChaudiere\core\application\services\UserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class CreateUserAction
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = json_decode((string)$request->getBody(), true);
        if (empty($data)) {
            throw new HttpBadRequestException($request, "Données manquantes");
        }

        $user = $this->userService->createUser($data);

        $response->getBody()->write(json_encode([
            'success' => true,
            'data' => $user
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}