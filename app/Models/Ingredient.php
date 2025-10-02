<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'is_tomato'];

    public function pizzas(): BelongsToMany
    {
        return $this->belongsToMany(Pizza::class)->withTimestamps();
    }

    public function appetizers(): BelongsToMany
    {
        return $this->belongsToMany(Appetizer::class)->withTimestamps();
    }

    public function desserts(): BelongsToMany
    {
        return $this->belongsToMany(Dessert::class)->withTimestamps();
    }

    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(Allergen::class)->withTimestamps();
    }
}
