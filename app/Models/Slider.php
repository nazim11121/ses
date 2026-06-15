<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_link',
        'image',
        'position',
        'active',
    ];

    public function getImageUrlAttribute()
    {
        return filter_var($this->image, FILTER_VALIDATE_URL)
            ? $this->image
            : asset($this->image);
    }
}
