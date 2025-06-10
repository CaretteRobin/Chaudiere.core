<?php

namespace LaChaudiere\webui\actions\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use LaChaudiere\core\application\services\UserService;
use Slim\Views\Twig;
use LaChaudiere\webui\traits\FlashRedirectTrait;

class DeleteUserAction
{
    use FlashRedirectTrait;
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke (Request $request, Response $response, array $args): Response
    {
        $userId = (string)$args['id'];
        if (!$userId) {
            throw new HttpNotFoundException($request, "ID manquant");
        }

        $this->userService->delete($userId);

        return $this->redirectWithFlash(
            $response,
            '/users',
            'Modification réussie !',
            'success'
        );

        
    }
}