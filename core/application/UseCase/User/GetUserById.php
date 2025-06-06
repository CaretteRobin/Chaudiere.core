<?php

namespace LaChaudiere\core\application\UseCase\User;

use LaChaudiere\core\application\interfaces\UserRepositoryInterface;
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
