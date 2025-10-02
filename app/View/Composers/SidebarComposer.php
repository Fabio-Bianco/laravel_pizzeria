<?php

namespace App\View\Composers;

use App\Models\Allergen;
use App\Models\Appetizer;
use App\Models\Beverage;
use App\Models\Category;
use App\Models\Dessert;
use App\Models\Ingredient;
use App\Models\Pizza;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with([
            'countPizzas' => Pizza::count(),
            'countAppetizers' => Appetizer::count(),
            'countBeverages' => Beverage::count(),
            'countDesserts' => Dessert::count(),
            'countIngredients' => Ingredient::count(),
            'countAllergens' => Allergen::count(),
            'countCategories' => Category::count(),
        ]);
    }
}