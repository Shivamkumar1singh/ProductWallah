<?php

namespace App\Http\Controllers\ProductManagement\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $categories = $this->service->list();
        return view('productManagement.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('childrenRecursive')->get();
        return view('productManagement.categories.create', compact('categories'));
    }

    public function store(CategoryStoreRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('admin.productManagement.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->with('childrenRecursive')
            ->get();

        return view('productManagement.categories.edit', compact('category', 'categories'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $this->service->update($category, $request->validated());

        return redirect()
            ->route('admin.productManagement.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $this->service->delete($category);

        return back()->with('success', 'Category deleted successfully!');
    }
}
