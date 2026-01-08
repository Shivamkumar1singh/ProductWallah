<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Vendor\Vendor;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'items',
        'subtotal',
        'discount_amount',
        'coupon_code',
        'total',
        'payment_status',
        'status',
        'payment_intent',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'pincode',
        'vendor_id',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function products()
    {
        return $this->belongsToMany(Products::class, 'order_product', 'order_id', 'product_item_id')
                    ->withPivot('vendor_id', 'quantity', 'price')
                    ->withTimestamps();
    }


    public function totalForVendor($vendorId)
    {
        return $this->products
                    ->where('pivot.vendor_id', $vendorId)
                    ->sum(function($product) {
                        return $product->pivot->price * $product->pivot->quantity;
                    });
    }


}
