<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Pizza extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'slug', 'price', 'notes', 'manual_allergens'];

    protected $casts = [
        'manual_allergens' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)->withTimestamps();
    }

    /**
     * Ottieni tutti gli allergeni calcolati automaticamente dagli ingredienti
     */
    public function getAutomaticAllergens(): Collection
    {
        return $this->ingredients()
            ->with('allergens')
            ->get()
            ->pluck('allergens')
            ->flatten()
            ->unique('id');
    }

    /**
     * Ottieni gli allergeni aggiunti manualmente
     */
    public function getManualAllergens(): Collection
    {
        if (empty($this->manual_allergens)) {
            return collect();
        }

        return Allergen::whereIn('id', $this->manual_allergens)->get();
    }

    /**
     * Ottieni tutti gli allergeni finali (automatici + manuali, senza duplicati)
     */
    public function getAllAllergens(): Collection
    {
        $automatic = $this->getAutomaticAllergens();
        $manual = $this->getManualAllergens();

        return $automatic->merge($manual)->unique('id')->sortBy('name');
    }

    /**
     * Verifica se la pizza contiene un allergene specifico
     */
    public function hasAllergen(int $allergenId): bool
    {
        return $this->getAllAllergens()->contains('id', $allergenId);
    }
}
