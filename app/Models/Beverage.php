<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beverage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'price', 'description', 'manual_allergens', 'image_path',
    ];

    protected $casts = [
        'image_path' => 'string',
    ];
}
