<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Pizza;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PizzaSeeder extends Seeder
{
    public function run(): void
    {
        $recipes = [
            [
                'name' => 'Margherita',
                'category' => 'Classiche',
                'price' => 6.50,
                'notes' => 'La pizza più amata di sempre',
                'ingredients' => ['Pomodoro', 'Mozzarella', 'Basilico'],
            ],
            [
                'name' => 'Prosciutto e Funghi',
                'category' => 'Classiche',
                'price' => 8.00,
                'notes' => 'Un classico intramontabile',
                'ingredients' => ['Pomodoro', 'Mozzarella', 'Prosciutto', 'Funghi'],
            ],
            [
                'name' => 'Quattro Formaggi',
                'category' => 'Bianche',
                'price' => 8.50,
                'notes' => 'Per gli amanti del formaggio',
                'ingredients' => ['Mozzarella', 'Gorgonzola', 'Parmigiano'],
            ],
            [
                'name' => 'Capricciosa',
                'category' => 'Classiche', 
                'price' => 9.00,
                'notes' => 'Ricca di sapori',
                'ingredients' => ['Pomodoro', 'Mozzarella', 'Prosciutto', 'Funghi', 'Olive', 'Uova'],
            ],
            [
                'name' => 'Quattro Stagioni',
                'category' => 'Classiche',
                'price' => 9.50,
                'notes' => 'Come le stagioni dell\'anno',
                'ingredients' => ['Pomodoro', 'Mozzarella', 'Prosciutto', 'Funghi', 'Olive'],
            ],
        ];

        foreach ($recipes as $recipe) {
            $categoryId = optional(Category::where('name', $recipe['category'])->first())->id;
            $pizza = Pizza::firstOrCreate(
                ['slug' => Str::slug($recipe['name'])],
                [
                    'name' => $recipe['name'],
                    'price' => $recipe['price'],
                    'notes' => $recipe['notes'] ?? null,
                    'category_id' => $categoryId,
                ]
            );

            $ingredientIds = Ingredient::whereIn('name', $recipe['ingredients'])->pluck('id');
            $pizza->ingredients()->sync($ingredientIds);
        }

        // Aggiungi almeno 10 pizze totali (se ne abbiamo meno, creiamo pizze random)
        $targetTotal = 10;
        $current = Pizza::count();
        if ($current < $targetTotal) {
            $toCreate = $targetTotal - $current;
            $categories = Category::pluck('id');
            $allIngredientIds = Ingredient::pluck('id');

            Pizza::factory()->count($toCreate)->make()->each(function (Pizza $pizza) use ($categories, $allIngredientIds) {
                $pizza->category_id = $categories->random();
                // Prezzo random ragionevole
                if (!$pizza->price || $pizza->price < 4) {
                    $pizza->price = fake()->randomFloat(2, 5, 16);
                }
                $pizza->save();
                $ingredientsToAttach = $allIngredientIds->shuffle()->take(rand(3, 6));
                $pizza->ingredients()->sync($ingredientsToAttach);
            });
        }
    }
}
