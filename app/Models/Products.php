<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Products extends Model
{
    protected $table= 'product_items';
    protected $fillable = ['category_id', 'name', 'slug', 'description', 'price', 'stock', 'image'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
{
    return $this->belongsToMany(Order::class, 'order_product', 'product_item_id', 'order_id')
                ->withPivot('vendor_id')
                ->withTimestamps();
}

public function vendor()
{
    return $this->belongsTo(Vendor::class, 'vendor_id');
}


}
