<?php

namespace LaChaudiere\core\application\services;
use Illuminate\Support\Str;
use LaChaudiere\core\application\interfaces\CategoryRepositoryInterface;
use LaChaudiere\core\application\UseCase\Category\CreateCategory;
use LaChaudiere\core\application\UseCase\Category\DeleteCategory;
use LaChaudiere\core\application\UseCase\Category\GetAllCategories;
use LaChaudiere\core\application\UseCase\Category\GetCategoryById;
use LaChaudiere\core\application\UseCase\Category\UpdateCategory;
use LaChaudiere\core\domain\entities\Category;

class CategoryService
{
    private GetAllCategories $getAllCategories;
    private GetCategoryById $getCategoryById;
    private CreateCategory $createCategory;
    private UpdateCategory $updateCategory;
    private DeleteCategory $deleteCategory;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->getAllCategories = new GetAllCategories($repository);
        $this->getCategoryById = new GetCategoryById($repository);
        $this->createCategory = new CreateCategory($repository);
        $this->updateCategory = new UpdateCategory($repository);
        $this->deleteCategory = new DeleteCategory($repository);
    }

    public function getAll(): array
    {
        return $this->getAllCategories->execute();
    }

    public function getById(string $id): ?Category
    {
        return $this->getCategoryById->execute($id);
    }

    public function create(array $data): Category
    {
        return $this->createCategory->execute($data);
    }

    public function update(string $id, array $data): ?Category
    {
        return $this->updateCategory->execute($id, $data);
    }

    public function delete(string $id): bool
    {
        return $this->deleteCategory->execute($id);
    }
}