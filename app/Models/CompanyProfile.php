<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'website',
        'tagline',
        'description',
        'facebook',
        'instagram',
        'active',
        'dhaka_delivery_charge',
        'outside_dhaka_delivery_charge',
    ];
}
