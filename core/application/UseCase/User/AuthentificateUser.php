<?php

namespace LaChaudiere\core\application\UseCase\User;

use LaChaudiere\core\application\interfaces\UserRepositoryInterface;
use LaChaudiere\core\Domain\Exception\AuthenticationFailedException;

class AuthenticateUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(string $username, string $plainPassword)
    {
        $user = $this->userRepository->findByUsername($username);

        if (!$user || !password_verify($plainPassword, $user->password)) {
            throw new AuthenticationFailedException("Invalid username or password.");
        }

        return $user;
    }
}
