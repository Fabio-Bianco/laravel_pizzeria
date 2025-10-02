<?php

namespace Database\Seeders;

use App\Models\Appetizer;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AppetizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Bruschette', 
                'price' => 4.50, 
                'description' => 'Pane tostato, pomodoro, basilico.',
                'ingredients' => ['Pomodoro', 'Basilico']
            ],
            [
                'name' => 'Olive all\'Ascolana', 
                'price' => 5.50, 
                'description' => 'Olive ripiene fritte.',
                'ingredients' => ['Uova']
            ],
            [
                'name' => 'Fritto misto', 
                'price' => 6.50, 
                'description' => 'Supplì, crocchette, anelli di cipolla.',
                'ingredients' => ['Mozzarella', 'Uova']
            ],
            [
                'name' => 'Antipasto misto', 
                'price' => 8.00, 
                'description' => 'Prosciutto, salame, formaggi misti.',
                'ingredients' => ['Prosciutto', 'Salame', 'Mozzarella', 'Parmigiano']
            ],
            [
                'name' => 'Caprese', 
                'price' => 5.00, 
                'description' => 'Mozzarella di bufala, pomodoro e basilico.',
                'ingredients' => ['Mozzarella', 'Pomodoro', 'Basilico']
            ],
        ];

        foreach ($items as $item) {
            $appetizer = Appetizer::firstOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'description' => $item['description'],
                ]
            );

            // Collega gli ingredienti
            if (isset($item['ingredients'])) {
                $ingredientIds = Ingredient::whereIn('name', $item['ingredients'])->pluck('id');
                $appetizer->ingredients()->sync($ingredientIds);
            }
        }
    }
}
