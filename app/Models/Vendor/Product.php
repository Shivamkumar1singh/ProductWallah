<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Explicit table name (important)
    protected $table = 'product_items';

    protected $fillable = [
        'vendor_id',
        'name',
        'price',
        'status',
        'category_id',
        'slug', 
        'description', 
        'stock', 
        'image'
    ];

    /**
     * Product belongs to a Vendor
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    
}
