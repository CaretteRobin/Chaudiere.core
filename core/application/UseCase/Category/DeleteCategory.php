<?php

namespace LaChaudiere\core\application\usecase\Category;

use LaChaudiere\core\application\interface\CategoryRepositoryInterface;

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
