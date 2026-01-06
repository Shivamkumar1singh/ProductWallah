<?php

namespace App\Http\Controllers\ProductManagement\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Services\ProductService;
use App\Models\Category;
use App\Models\Products;

class ProductsController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $products = $this->service->all();
        return view('productManagement.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::with('children')->get();
        return view('productManagement.product.create', compact('categories'));
    }

    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        $imagePath = null;
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store(
                'products',     // folder inside storage/app/public
                'public'        // disk
            );
        }

        $this->service->create($data);

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
        $data = $request->validated();

        // Handle image upload (CORRECT WAY) 
        if ($request->hasFile('image')) {
    
            // Delete old image (important)
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
    
            // Store new image in storage/app/public/products
            $imagePath = $request->file('image')->store('products', 'public');
    
            // Save FULL relative path
            $product->image = $imagePath;
        }

        $this->service->update($product, $data);

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
