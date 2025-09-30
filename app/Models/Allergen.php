<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Allergen extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)->withTimestamps();
    }
}
