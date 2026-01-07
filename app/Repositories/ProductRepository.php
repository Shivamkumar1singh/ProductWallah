<?php

namespace App\Repositories;

use App\Models\Products;

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
        $product->update($data);
        return $product;
    }

    public function delete(Products $product)
    {
        return $product->delete();
    }
}
 