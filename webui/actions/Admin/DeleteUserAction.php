<?php

namespace LaChaudiere\webui\actions\Admin;

use LaChaudiere\core\application\services\UserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class DeleteUserAction
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'] ?? null;
        if (!$id) {
            throw new HttpNotFoundException($request, "ID manquant");
        }

        $deleted = $this->userService->deleteUser($id);
        if (!$deleted) {
            throw new HttpNotFoundException($request, "Utilisateur non trouvé");
        }

        $response->getBody()->write(json_encode([
            'success' => true,
            'message' => "Utilisateur supprimé"
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}