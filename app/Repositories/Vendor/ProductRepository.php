<?php

namespace App\Repositories\Vendor;

use App\Models\Vendor\Product;

class ProductRepository
{
    public function paginateByVendor(int $vendorId, int $perPage = 10)
    {
        return Product::where('vendor_id', $vendorId)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    } 

    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }
} 
