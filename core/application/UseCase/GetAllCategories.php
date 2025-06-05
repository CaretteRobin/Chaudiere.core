<?php

namespace LaChaudiere\core\Application\UseCase;

use LaChaudiere\core\Application\Interface\CategoryRepositoryInterface;

class GetAllCategories
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository) {}

    public function execute(): array
    {
        return $categoryRepository->findAll();
    }
}
