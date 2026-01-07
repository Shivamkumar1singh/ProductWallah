<?php

namespace App\Http\Controllers\ProductManagement\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Models\Category;
use App\Models\Products;

class ProductsController extends Controller
{
    protected $service;
    protected $categoryService;

    public function __construct(ProductService $service, CategoryService $categoryService)
    {
        $this->service = $service;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $products = $this->service->all();
        return view('productManagement.product.index', compact('products'));
    }

    public function create()
    {
        $categories = $this->categoryService->getForProductForm();

        return view('productManagement.product.create', compact('categories'));
    }

    public function store(ProductStoreRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('admin.productManagement.product.index') 
            ->with('success', 'Product added successfully!');
    }

    public function edit(Products $product)
    {
        $categories = Category::with('children')->get();
        return view('productManagement.product.edit', compact('product', 'categories'));
    }

    public function update(ProductUpdateRequest $request, Products $product)
    {
        $this->service->update($product, $request->validated());
        
        return redirect()
            ->route('admin.productManagement.product.index')
            ->with('success', 'Product updated!');
    }

    public function destroy(Products $product)
    {
        $this->service->delete($product);

        return back()->with('success', 'Product deleted!');
    }
}
