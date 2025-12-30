<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryRepository
{
    public function getAll()
{
    return Category::whereNull('parent_id')
        ->where('status', 1)
        ->with('childrenRecursive')
        ->latest()
        ->get();
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
        if ($category->children()->exists()) {
            throw new \Exception('Cannot delete category with child categories.');
        }
        return $category->delete();
    }
}
