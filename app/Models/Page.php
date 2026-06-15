<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'sidebar_title',
        'sidebar_text',
        'feature_one_title',
        'feature_one_text',
        'feature_two_title',
        'feature_two_text',
    ];
}
