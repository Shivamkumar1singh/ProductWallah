<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $repo;

    public function __construct(CategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getForProductForm()
    {
        return $this->repo->getAll();
    }

    public function list()
    {
        return $this->repo->getAll();
    }

    public function create(array $data)
    {
        return $this->repo->store($data);
    }

    public function update(Category $category, array $data)
    {
        return $this->repo->update($category, $data);
    }

    public function delete(Category $category)
    {
        return $this->repo->delete($category);
    }
}
