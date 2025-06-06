<?php

namespace LaChaudiere\core\application\UseCase\Category;

use LaChaudiere\core\application\interfaces\CategoryRepositoryInterface;
use LaChaudiere\core\domain\entities\Category;

class CreateCategory
{
    protected CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $data): Category
    {
        return $this->repository->create($data);
    }
}
