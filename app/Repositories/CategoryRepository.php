<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryRepository
{
    public function getAll()
    {
        return Category::with('parent')->latest()->get();
    }

    public function store(array $data)
    {
        return Category::create([
            'parent_id' => $data['parent_id'] ?? null,
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);
    }

    public function update(Category $category, array $data)
    {
        return $category->update([
            'parent_id' => $data['parent_id'] ?? null,
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }
}
