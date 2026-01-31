<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_description',
        'product_price',
        'departure_locations',
        'product_image',
        'is_published'
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'product_image' => 'array',
        'is_published' => 'boolean',
    ];
}
