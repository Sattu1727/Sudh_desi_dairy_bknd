<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'category_id',
        'status'
    ];

    // Generate a unique category_id before saving
    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->category_id = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT); // Generate unique 6-digit category_id
        });
    }
}
