<?php

namespace LaChaudiere\core\application\interfaces;

use LaChaudiere\core\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function findById(string $id): ?User;

    public function findByUsername(string $username): ?User;

    public function findByEmail(string $email): ?User;

    public function save(User $user): User;
}
