<?php

namespace LaChaudiere\core\application\UseCase\Category;

use LaChaudiere\core\application\interfaces\CategoryRepositoryInterface;
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
