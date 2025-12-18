<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'parent_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function products()
    {
        return $this->hasMany(Products::class, 'category_id');
    }

    // Parent category (Electronics)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    
    // Child categories (Smartphones, AC, etc.)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->where('status', 1);
    }


    
}
