<?php

namespace LaChaudiere\core\Application\Interface;

use LaChaudiere\core\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function findByUsername(string $username): ?User;

    public function save(User $user): User;
}
