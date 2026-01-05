<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 
        'type', 
        'value',
        'min_order_amount',
        'start_date', 
        'end_date',
        'usage_limit', 
        'used_count',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_active'  => 'boolean',
    ];

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function isValid(): bool
    {
        if (! $this->is_active) {
            return false;
        }
    
        if ($this->start_date && $this->start_date->isFuture()) {
            return false;
        }
    
        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }
    
        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }
    
        return true;
    }

}
