<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\StoreProductRequest;
use App\Http\Requests\Vendor\UpdateProductRequest;
use App\Models\Vendor\Product;      
use App\Services\Vendor\ProductService;

class ProductController extends Controller
{
    public function __construct(protected ProductService $service)
    {

    }

    public function index()
    {
        $products = $this->service->list();

        return view('vendor.productManagement.product.index', compact('products'));
    }

    public function create()
    {
        return view('vendor.productManagement.product.create');
    }

    public function store(StoreProductRequest $request)
    {
        $this->service->store($request->validated());
    
        return redirect()->route('vendor.productManagement.product.index')
                         ->with('success', 'Product created successfully');
    }



    public function edit(Product $product)
    {
        $this->authorizeVendorProduct($product);
        return view('vendor.productManagement.product.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorizeVendorProduct($product);

        $this->service->update($product, $request->validated());
    
        return redirect()->route('vendor.productManagement.product.index')
                         ->with('success', 'Product updated successfully');
    }
    
    public function destroy(Product $product)
    {
        $this->authorizeVendorProduct($product);
        $this->service->delete($product);

        return redirect()->route('vendor.productManagement.product.index')
                         ->with('success', 'Product deleted successfully');
    }

    private function authorizeVendorProduct(Product $product)
    {
        if ($product->vendor_id != auth('vendor')->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
