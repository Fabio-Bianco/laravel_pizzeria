<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Appetizer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'price', 'description', 'manual_allergens', 'is_vegan'
    ];

    protected $casts = [
        'manual_allergens' => 'array',
        'is_vegan' => 'boolean',
    ];

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
     * Verifica se l'antipasto contiene un allergene specifico
     */
    public function hasAllergen(int $allergenId): bool
    {
        return $this->getAllAllergens()->contains('id', $allergenId);
    }

    /**
     * Relazione molti-a-molti con Allergen
     */
    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(Allergen::class)->withTimestamps();
    }
}
