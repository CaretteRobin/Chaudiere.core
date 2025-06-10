<?php

namespace LaChaudiere\infra\persistence\Eloquent;

use Illuminate\Support\Str;
use LaChaudiere\core\application\interfaces\CategoryRepositoryInterface;
use LaChaudiere\core\domain\entities\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll(): array
    {
        return Category::all()->all();
    }

    public function findById(string $id): ?Category
    {
        return Category::find($id);
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(int $id, array $data): ?Category
    {
        $category = Category::find($id);
        if (!$category) return null;

        $category->update($data);
        return $category;
    }

    public function delete(int $id): bool
    {
        $category = Category::find($id);
        if (!$category) return false;

        return $category->delete();
    }
}
