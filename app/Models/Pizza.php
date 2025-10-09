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

    protected $fillable = ['category_id', 'name', 'slug', 'price', 'notes', 'manual_allergens', 'is_vegan', 'image_path'];

    protected $casts = [
        'manual_allergens' => 'array',
        'is_vegan' => 'boolean',
        'image_path' => 'string',
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
     * OTTIMIZZATO: usa relazioni già caricate se disponibili
     */
    public function getAutomaticAllergens(): Collection
    {
        // Se gli ingredienti e i loro allergeni sono già caricati, usali
        if ($this->relationLoaded('ingredients')) {
            return $this->ingredients
                ->pluck('allergens')
                ->flatten()
                ->unique('id');
        }
        
        // Fallback: query normale (solo se non in eager loading)
        return $this->ingredients()
            ->with('allergens')
            ->get()
            ->pluck('allergens')
            ->flatten()
            ->unique('id');
    }

    /**
     * Ottieni gli allergeni aggiunti manualmente
     * OTTIMIZZATO: usa cache locale
     */
    public function getManualAllergens(): Collection
    {
        if (empty($this->manual_allergens)) {
            return collect();
        }

        // Cache locale per evitare query ripetute
        if (!isset($this->_cached_manual_allergens)) {
            $this->_cached_manual_allergens = Allergen::whereIn('id', $this->manual_allergens)->get();
        }
        
        return $this->_cached_manual_allergens;
    }

    /**
     * Ottieni tutti gli allergeni finali (automatici + manuali, senza duplicati)
     * OTTIMIZZATO: usa cache e relazioni precaricate
     */
    public function getAllAllergens(): Collection
    {
        // Cache locale per evitare ricalcoli multipli
        if (!isset($this->_cached_all_allergens)) {
            $automatic = $this->getAutomaticAllergens();
            $manual = $this->getManualAllergens();
            $this->_cached_all_allergens = $automatic->merge($manual)->unique('id')->sortBy('name');
        }

        return $this->_cached_all_allergens;
    }

    /**
     * Verifica se la pizza contiene un allergene specifico
     */
    public function hasAllergen(int $allergenId): bool
    {
        return $this->getAllAllergens()->contains('id', $allergenId);
    }
}
