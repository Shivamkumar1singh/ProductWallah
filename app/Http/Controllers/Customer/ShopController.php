<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
// use App\Http\Requests\Shop\ShopIndexRequest;
use App\Models\Category;
use App\Services\ShopService;

class ShopController extends Controller
{
    protected $service;

    public function __construct(ShopService $service)
    {
        $this->service = $service;
    }

    /**
     * Display the shop page.
     */
    public function index(ShopService $request)
    {
        $data = $this->service->getShopData();

        return view('shop.index', [
            'categories' => $data['categories'],
            'featuredCategories' => $data['featuredCategories'],
            'products' => $data['products'],
        ]);
    }

    public function category(Category $category)
    {
        $products = $this->service->getProductsByCategory($category);
    
        // Pass categories for dropdown
        $data = $this->service->getShopData();

        // Use the same shop.index view so the navbar & dropdown remain
        return view('shop.index', [
            'categories' => $data['categories'],
            'featuredCategories' => $data['featuredCategories'],
            'products' => $products,
            'selectedCategory' => $category, // for highlighting
        ]);
    }

}
