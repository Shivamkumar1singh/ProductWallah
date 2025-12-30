<?php

namespace App\Models\Vendor;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Vendor\Vendor;
use App\Models\Vendor\Product;


class Vendor extends Authenticatable
{
    use Notifiable;

    // Mass assignable fields
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Hidden fields
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
{
    return $this->hasManyThrough(Order::class, Product::class, 'vendor_id', 'id', 'id', 'id');
}

}
