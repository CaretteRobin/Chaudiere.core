<?php

namespace LaChaudiere\core\Application\UseCase\User;

use LaChaudiere\core\Application\Interface\UserRepositoryInterface;
use LaChaudiere\core\Domain\Entities\User;
use LaChaudiere\core\Domain\Exception\UserAlreadyExistsException;

class RegisterUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(string $username, string $plainPassword, string $role = 'user'): User
    {
        if ($this->userRepository->findByUsername($username)) {
            throw new UserAlreadyExistsException("User with username '$username' already exists.");
        }

        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

        $user = new User([
            'username' => $username,
            'password' => $hashedPassword,
            'role' => $role,
            'created_at' => now()
        ]);

        return $this->userRepository->save($user);
    }
}
