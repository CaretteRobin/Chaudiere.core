<?php

namespace LaChaudiere\core\Application\UseCase\User;

use LaChaudiere\core\Application\Interface\UserRepositoryInterface;
use LaChaudiere\core\Domain\Exception\UserNotFoundException;

class GetUserById
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(int $id)
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new UserNotFoundException("User with ID $id not found.");
        }

        return $user;
    }
}
