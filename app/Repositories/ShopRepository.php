<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Products;

class ShopRepository
{
    /**
     * Get all active categories.
     */
    public function getActiveCategories()
    {
        return Category::with('children')
            ->where('status', 1)
            ->get();
    }

    /**
     * Get featured categories.
     */
    public function getFeaturedCategories($limit = 4)
    {
        return Category::where('is_featured', 1)
            ->where('status', 1)
            ->limit($limit)
            ->get();
    }

    /**
     * Get products with active status.
     */
    public function getActiveProducts($limit = 20)
    {
        return Products::where('status', 1)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get products by category (recursive)
     */
    public function getProductsByCategory(Category $category)
    {
        $categoryIds = $this->getRecursiveCategoryIds($category);

        return Products::whereIn('category_id', $categoryIds)
            ->where('status', 1)
            ->latest()
            ->get();
    }

    /**
     * Recursive helper to collect child category IDs
     */
    protected function getRecursiveCategoryIds(Category $category, &$ids = [])
    {
        $ids[] = $category->id;

        foreach ($category->children as $child) {
            $this->getRecursiveCategoryIds($child, $ids);
        }

        return $ids;
    }
}
