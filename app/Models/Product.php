<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'stock',
        'active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute()
    {
        if (! $this->image) {
            return asset('images/default-saree.jpg');
        }

        return filter_var($this->image, FILTER_VALIDATE_URL)
            ? $this->image
            : asset($this->image);
    }
}
