<?php

namespace LaChaudiere\core\application\UseCase\Category;

use LaChaudiere\core\application\interfaces\CategoryRepositoryInterface;

class GetAllCategories
{
    protected CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->getAll();
    }
}
