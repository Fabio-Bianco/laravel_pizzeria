<?php

namespace Database\Seeders;

use App\Models\Allergen;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'Mozzarella' => ['Lattosio'],
            'Pomodoro' => [],
            'Basilico' => [],
            'Prosciutto' => [],
            'Funghi' => [],
            'Gorgonzola' => ['Lattosio'],
            'Noci' => ['Noci'],
            'Parmigiano' => ['Lattosio'],
            'Uova' => ['Uova'],
            'Tonno' => [],
            'Acciughe' => [],
            'Olive' => [],
            'Rucola' => [],
            'Salame' => [],
        ];

        foreach ($map as $name => $allergens) {
            $ingredient = Ingredient::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'is_tomato' => Str::slug($name) === 'pomodoro']
            );

            $ids = Allergen::whereIn('name', $allergens)->pluck('id');
            $ingredient->allergens()->syncWithoutDetaching($ids);
        }
    }
}
