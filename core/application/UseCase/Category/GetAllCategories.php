<?php

namespace LaChaudiere\core\application\usecase\Category;

use LaChaudiere\core\application\interface\CategoryRepositoryInterface;

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
