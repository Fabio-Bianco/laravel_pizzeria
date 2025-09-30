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
        ];

        foreach ($map as $name => $allergens) {
            $ingredient = Ingredient::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );

            $ids = Allergen::whereIn('name', $allergens)->pluck('id');
            $ingredient->allergens()->syncWithoutDetaching($ids);
        }
    }
}
