<?php

namespace LaChaudiere\core\application\interfaces;

use LaChaudiere\core\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function findById(string $id): ?User;
    public function findByEmail(string $email): ?User;
    public function save(User $user): User;
    public function delete(string $id): bool;
    public function findAll(): array;
    public function update(string $id, array $data): bool;
}
