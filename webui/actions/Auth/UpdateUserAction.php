<?php
declare(strict_types=1);

namespace LaChaudiere\webui\actions\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use LaChaudiere\core\application\services\UserService;
use Slim\Views\Twig;
use LaChaudiere\webui\traits\FlashRedirectTrait;

class UpdateUserAction
{
    use FlashRedirectTrait;
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $userId = (string)$args['id'];
        $data = (array)$request->getParsedBody();

        if(isset($data['email'])){
            if(filter_var($data['email'], FILTER_SANITIZE_EMAIL) !== $data['email']){
                return $this->redirectWithFlash(
                    $response,
                    '/users/' . $userId,
                    'Données email invalides.',
                    'error'
                );
            }
        }else if (isset($data['password'])){
            if(!isset($data['cpassword'])){
                return $this->redirectWithFlash(
                    $response,
                    '/users/' . $userId,
                    'Tout les champs doivent etre remplie',
                    'error'
                );
            }
            if($data['password'] !== $data['cpassword']){
                return $this->redirectWithFlash(
                    $response,
                    '/users/' . $userId,
                    'Les passwords doivent etre identique.',
                    'error'
                );
            }
            unset($data['cpassword']);
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }else if (isset($data['role'])){
            if($data['role'] !== 'admin' && $data['role'] !== 'super-admin'){
                return $this->redirectWithFlash(
                    $response,
                    '/users/' . $userId,
                    'Données roles invalides.',
                    'error'
                );
            }
        }else{
            return $this->redirectWithFlash(
                $response,
                '/users/' . $userId,
                'Bizarre rien a été fait',
                'error'
            );
        }

        unset($data['csrf_token']);
        unset($data['field']);
        $updatedUser = $this->userService->update($userId, $data);

        return $this->redirectWithFlash(
            $response,
            '/users/' . $userId,
            'Modification réussie !',
            'success'
        );
    }
}
