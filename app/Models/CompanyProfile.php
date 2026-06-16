<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_name',
        'email',
        'phone',
        'mobile_number',
        'address',
        'website',
        'tagline',
        'description',
        'company_logo',
        'favicon_icon',
        'facebook',
        'instagram',
        'active',
        'dhaka_delivery_charge',
        'outside_dhaka_delivery_charge',
    ];
}
