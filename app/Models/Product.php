<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'description', 'price', 'stock',
        'image_url', 'material', 'color', 'size', 'pattern', 'ecommerce_link'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
