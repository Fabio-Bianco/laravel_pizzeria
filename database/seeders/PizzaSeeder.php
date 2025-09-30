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
                'ingredients' => ['Pomodoro', 'Mozzarella', 'Basilico'],
            ],
            [
                'name' => 'Prosciutto e Funghi',
                'category' => 'Classiche',
                'price' => 8.00,
                'ingredients' => ['Pomodoro', 'Mozzarella', 'Prosciutto', 'Funghi'],
            ],
            [
                'name' => 'Quattro Formaggi',
                'category' => 'Bianche',
                'price' => 8.50,
                'ingredients' => ['Mozzarella', 'Gorgonzola'],
            ],
        ];

        foreach ($recipes as $r) {
            $categoryId = optional(Category::where('name', $r['category'])->first())->id;
            $pizza = Pizza::firstOrCreate(
                ['slug' => Str::slug($r['name'])],
                [
                    'name' => $r['name'],
                    'price' => $r['price'],
                    'description' => null,
                    'category_id' => $categoryId,
                ]
            );

            $ingIds = Ingredient::whereIn('name', $r['ingredients'])->pluck('id');
            $pizza->ingredients()->sync($ingIds);
        }

        // Aggiungi almeno 10 pizze totali (se ne abbiamo meno, creiamo pizze random)
        $targetTotal = 10;
        $current = Pizza::count();
        if ($current < $targetTotal) {
            $toCreate = $targetTotal - $current;
            $categories = Category::pluck('id');
            $allIngredientIds = Ingredient::pluck('id');

            Pizza::factory()->count($toCreate)->make()->each(function (Pizza $p) use ($categories, $allIngredientIds) {
                $p->category_id = $categories->random();
                // Prezzo random ragionevole
                if (!$p->price || $p->price < 4) {
                    $p->price = fake()->randomFloat(2, 5, 16);
                }
                $p->save();
                $attach = $allIngredientIds->shuffle()->take(rand(3, 6));
                $p->ingredients()->sync($attach);
            });
        }
    }
}
