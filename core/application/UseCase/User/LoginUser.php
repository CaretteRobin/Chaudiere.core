<?php

namespace LaChaudiere\core\application\UseCase\User;

use LaChaudiere\core\application\exceptions\UserExceptions\AuthenticationFailedException;
use LaChaudiere\core\application\interfaces\UserRepositoryInterface;
use LaChaudiere\core\domain\entities\User;

class LoginUser
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function execute(string $email, string $password): User
    {
        try {
            $user = $this->userRepository->findByEmail($email);
            if (!$user || !password_verify($password, $user->password)) {
                throw new AuthenticationFailedException("Email ou mot de passe incorrect.");
            }

            return $user;
        } catch (AuthenticationFailedException $e) {
            throw new AuthenticationFailedException();
        }
    }
}
