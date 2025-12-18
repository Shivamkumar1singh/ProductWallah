<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\ShopRepository;


class ShopService
{
    protected $shopRepository;

    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    public function getShopData()
    {
        return [
            'categories' => $this->shopRepository->getActiveCategories(),
            'featuredCategories' => $this->shopRepository->getFeaturedCategories(),
            'products' => $this->shopRepository->getActiveProducts(),
        ];
    }

    public function getProductsByCategory(Category $category)
    {
        return $this->shopRepository->getProductsByCategory($category);
    }

    
}
