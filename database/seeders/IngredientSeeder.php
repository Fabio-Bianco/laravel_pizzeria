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
            'Pomodoro' => ['Nichel'],
            'Basilico' => [],
            'Prosciutto cotto' => [],
            'Prosciutto crudo' => [],
            'Funghi champignon' => ['Nichel'],
            'Funghi porcini' => ['Nichel'],
            'Gorgonzola' => ['Lattosio'],
            'Parmigiano' => ['Lattosio'],
            'Scamorza' => ['Lattosio'],
            'Uova' => ['Uova'],
            'Tonno' => [],
            'Acciughe' => [],
            'Olive nere' => [],
            'Olive verdi' => [],
            'Rucola' => [],
            'Salame piccante' => [],
            'Salame dolce' => [],
            'Cipolla rossa' => [],
            'Carciofi' => [],
            'Peperoni' => [],
            'Zucchine' => [],
            'Melanzane' => [],
            'Wurstel' => [],
            'Speck' => [],
            'Frutti di mare' => ['Noci'],
            'Patate' => [],
            'Mais' => [],
            'Spinaci' => [],
            'Bresaola' => [],
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
