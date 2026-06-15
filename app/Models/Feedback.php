<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'name',
        'designation',
        'message',
        'image',
        'position',
        'active',
    ];

    public function getImageUrlAttribute()
    {
        if (! $this->image) {
            return asset('images/default-avatar.png');
        }

        return filter_var($this->image, FILTER_VALIDATE_URL)
            ? $this->image
            : asset($this->image);
    }
}
