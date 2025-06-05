<?php

namespace LaChaudiere\core\application\interfaces;

use LaChaudiere\core\domain\entities\Category;

interface CategoryRepositoryInterface
{
    public function getAll(): array;

    public function findById(int $id): ?Category;

    public function create(array $data): Category;

    public function update(int $id, array $data): ?Category;

    public function delete(int $id): bool;
}
