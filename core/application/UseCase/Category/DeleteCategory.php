<?php

namespace LaChaudiere\core\application\UseCase\Category;

use LaChaudiere\core\application\interfaces\CategoryRepositoryInterface;

class DeleteCategory
{
    protected CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
