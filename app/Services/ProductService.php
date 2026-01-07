<?php

namespace App\Services;

use App\Models\Products;
use Illuminate\Support\Facades\Storage;
use App\Repositories\ProductRepository;
use Illuminate\Support\Str;

class ProductService
{
    protected $repo;

    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    public function all()
    {
        return $this->repo->all();
    }

    public function create(array $data)
    {
        $data['slug'] = Str::slug($data['name']) . '-' . time();

        // Image upload
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('products', 'public');
        }

 
        return $this->repo->create($data);
    }



    public function update(Products $product, array $data)
    {
        // Update slug only if name changed
        if ($product->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']) . '-' . time();
        }

        // Handle image replacement
        if (isset($data['image'])) {

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $data['image']->store('products', 'public');
        }

        return $this->repo->update($product, $data);
    }

    public function delete(Products $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return $this->repo->delete($product);
    }
}
