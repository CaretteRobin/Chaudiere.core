<?php

namespace LaChaudiere\core\application\UseCase\Category;

use LaChaudiere\core\application\interfaces\CategoryRepositoryInterface;
use LaChaudiere\core\domain\entities\Category;

class UpdateCategory
{
    protected CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id, array $data): ?Category
    {
        return $this->repository->update($id, $data);
    }
}
