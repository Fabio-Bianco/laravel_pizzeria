<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\Cache;

/**
 * Trait per gestire il caching intelligente nei controller
 * SENZA modificare le funzionalità esistenti
 */
trait WithCaching
{
    /**
     * Cache per i conteggi del dashboard con TTL di 5 minuti
     */
    protected function getCachedCounts(): array
    {
        return Cache::remember('dashboard.counts', 300, function () {
            return [
                'countAppetizers' => \App\Models\Appetizer::count(),
                'countPizzas' => \App\Models\Pizza::count(),
                'countBeverages' => \App\Models\Beverage::count(),
                'countDesserts' => \App\Models\Dessert::count(),
                'countAllergens' => \App\Models\Allergen::count(),
                'countIngredients' => \App\Models\Ingredient::count(),
                'countCategories' => \App\Models\Category::count(),
            ];
        });
    }
    
    /**
     * Cache per i filtri delle select con TTL di 10 minuti
     */
    protected function getCachedFilters(): array
    {
        return Cache::remember('filters.options', 600, function () {
            return [
                'categories' => \App\Models\Category::orderBy('name')->pluck('name', 'id'),
                'ingredients' => \App\Models\Ingredient::orderBy('name')->pluck('name', 'id'),
                'allergens' => \App\Models\Allergen::orderBy('name')->pluck('name', 'id'),
            ];
        });
    }
    
    /**
     * Cache per gli ultimi elementi con TTL di 2 minuti
     */
    protected function getCachedLatestItems(): array
    {
        return Cache::remember('dashboard.latest', 120, function () {
            return [
                'latestPizza' => \App\Models\Pizza::latest()->first(),
                'latestAppetizer' => \App\Models\Appetizer::latest()->first(),
                'latestBeverage' => \App\Models\Beverage::latest()->first(),
                'latestDessert' => \App\Models\Dessert::latest()->first(),
            ];
        });
    }
    
    /**
     * Invalida le cache quando i dati vengono modificati
     */
    protected function clearRelevantCaches(): void
    {
        Cache::forget('dashboard.counts');
        Cache::forget('filters.options');
        Cache::forget('dashboard.latest');
    }
}