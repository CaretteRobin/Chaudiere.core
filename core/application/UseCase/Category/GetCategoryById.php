<?php

namespace LaChaudiere\core\application\usecase\Category;

use LaChaudiere\core\application\interface\CategoryRepositoryInterface;
use LaChaudiere\core\domain\entities\Category;

class GetCategoryById
{
    protected CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): ?Category
    {
        return $this->repository->findById($id);
    }
}
