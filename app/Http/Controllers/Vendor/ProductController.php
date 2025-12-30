<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\Product;      
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('vendor_id', auth('vendor')->id())
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return view('vendor.productManagement.product.index', compact('products'));
    }

    public function create()
    {
        return view('vendor.productManagement.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'stock'       => 'nullable|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = $filename; // store only filename
        }
        
    
        // Create product
        Product::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . time(),
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'stock'       => $request->stock ?? 0,
            'vendor_id'   => auth('vendor')->id(),
            'status'      => 1,
            'image'       => $imagePath,
        ]);
    
        return redirect()->route('vendor.productManagement.product.index')
                         ->with('success', 'Product created successfully');
    }



    public function edit(Product $product)
    {
        $this->authorizeVendorProduct($product);
        return view('vendor.productManagement.product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeVendorProduct($product);
    
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'stock'       => 'nullable|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Handle image upload if new image is provided
        if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/products'), $filename);
        $product->image = $filename; // only filename
    }
    
        // Update product
        $product->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . time(),
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'stock'       => $request->stock ?? 0,
        ]);
    
        $product->save();
    
        return redirect()->route('vendor.productManagement.product.index')
                         ->with('success', 'Product updated successfully');
    }
    
    public function destroy(Product $product)
    {
        $this->authorizeVendorProduct($product);
        $product->delete();

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
