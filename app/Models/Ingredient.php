<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function pizzas(): BelongsToMany
    {
        return $this->belongsToMany(Pizza::class)->withTimestamps();
    }

    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(Allergen::class)->withTimestamps();
    }
}
