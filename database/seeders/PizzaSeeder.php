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
                'notes' => 'Pomodoro San Marzano DOP, mozzarella fior di latte, basilico fresco, olio EVO.',
                'ingredients' => ['Pomodoro', 'Mozzarella', 'Basilico'],
            ],
            [
                'name' => 'Marinara',
                'category' => 'Classiche',
                'price' => 5.50,
                'notes' => 'Pomodoro, aglio, origano, olio EVO.',
                'ingredients' => ['Pomodoro'],
            ],
            [
                'name' => 'Diavola',
                'category' => 'Classiche',
                'price' => 8.00,
                'notes' => 'Pomodoro, mozzarella, salame piccante.',
                'ingredients' => ['Pomodoro', 'Mozzarella', 'Salame'],
            ],
            [
                'name' => 'Quattro Formaggi',
                'category' => 'Bianche',
                'price' => 8.50,
                'notes' => 'Mozzarella, gorgonzola, parmigiano, formaggio dolce.',
                'ingredients' => ['Mozzarella', 'Gorgonzola', 'Parmigiano'],
            ],
            [
                'name' => 'Capricciosa',
                'category' => 'Classiche',
                'price' => 9.00,
                'notes' => 'Pomodoro, mozzarella, prosciutto cotto, funghi, olive, carciofi, uovo.',
                'ingredients' => ['Pomodoro', 'Mozzarella', 'Prosciutto', 'Funghi', 'Olive', 'Uova'],
            ],
            [
                'name' => 'Quattro Stagioni',
                'category' => 'Classiche',
                'price' => 9.50,
                'notes' => 'Pomodoro, mozzarella, prosciutto cotto, funghi, olive, carciofi.',
                'ingredients' => ['Pomodoro', 'Mozzarella', 'Prosciutto', 'Funghi', 'Olive'],
            ],
            [
                'name' => 'Bufalina',
                'category' => 'Speciali',
                'price' => 10.00,
                'notes' => 'Pomodoro, mozzarella di bufala DOP, basilico, olio EVO.',
                'ingredients' => ['Pomodoro', 'Mozzarella', 'Basilico'],
            ],
            [
                'name' => 'Tonno e Cipolla',
                'category' => 'Classiche',
                'price' => 8.50,
                'notes' => 'Pomodoro, mozzarella, tonno, cipolla rossa.',
                'ingredients' => ['Pomodoro', 'Mozzarella', 'Tonno'],
            ],
            [
                'name' => 'Vegetariana',
                'category' => 'Speciali',
                'price' => 9.00,
                'notes' => 'Pomodoro, mozzarella, verdure grigliate di stagione.',
                'ingredients' => ['Pomodoro', 'Mozzarella'],
            ],
            [
                'name' => 'Rucola e Grana',
                'category' => 'Bianche',
                'price' => 9.00,
                'notes' => 'Mozzarella, rucola fresca, scaglie di parmigiano, olio EVO.',
                'ingredients' => ['Mozzarella', 'Rucola', 'Parmigiano'],
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
    }
}
