<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'surface_area',
        'floors',
        'bedrooms',
        'bathrooms',
        'price',
        'image_path',
        'plan_2d_path',
        'panorama_image_path',
        'is_published',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
