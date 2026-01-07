<?php

namespace App\Services\Vendor;

use App\Models\Vendor\Product;
use App\Repositories\Vendor\ProductRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(
        protected ProductRepository $repository
    ) {}

    public function list()
    {
        return $this->repository->paginateByVendor(auth('vendor')->id());
    } 

    public function store(array $data)
    {
        $data['vendor_id'] = auth('vendor')->id();
        $data['slug'] = Str::slug($data['name']) . '-' . time();
        $data['status'] = 1;
        $data['stock'] = $data['stock'] ?? 0;

        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('products', 'public');
        }

        return $this->repository->create($data);
    }

    public function update(Product $product, array $data)
    {
        if (isset($data['image'])) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $data['image']->store('products', 'public');
        }

        $data['slug'] = Str::slug($data['name']) . '-' . time();
        $data['stock'] = $data['stock'] ?? 0;

        return $this->repository->update($product, $data);
    }

    public function delete(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return $this->repository->delete($product);
    }
}
 