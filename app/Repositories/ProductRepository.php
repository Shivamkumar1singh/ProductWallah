<?php

namespace App\Repositories;

use App\Models\Products;
use Illuminate\Support\Facades\File;

class ProductRepository 
{
    public function all($perPage = 10)
    {
        return Products::with('category')->latest()->paginate($perPage);
    }

    public function find($id)
    {
        return Products::findOrFail($id);
    }

    public function create(array $data)
    {
        return Products::create($data);
    }

    public function update(Products $product, array $data)
    {
        if (isset($data['image']) && $product->image) {
            $oldPath = public_path('uploads/products/' . $product->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $product->update($data);
    }

    public function delete($product)
    {
        if ($product->image) {
            $path = public_path('uploads/products/' . $product->image);
            try {
                if (File::exists($path)) {
                    File::delete($path);
                }
            } catch (\Exception $e) {
                \Log::error("Failed to delete product image: ".$e->getMessage());
            }
        }

        return $product->delete();
    }
}
 