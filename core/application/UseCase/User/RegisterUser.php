<?php

namespace LaChaudiere\core\application\UseCase\User;

use LaChaudiere\core\application\interfaces\UserRepositoryInterface;
use LaChaudiere\core\Domain\Entities\User;
use LaChaudiere\core\Domain\Exception\UserAlreadyExistsException;

class RegisterUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(string $id, string $plainPassword, string $role = 'user'): User
    {
        if ($this->userRepository->findById($id)) {
            throw new UserAlreadyExistsException("User with username '$id' already exists.");
        }

        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

        $user = new User([
            'id' => $id,
            'password' => $hashedPassword,
            'role' => $role,
            'created_at' => now()
        ]);

        return $this->userRepository->save($user);
    }
}
