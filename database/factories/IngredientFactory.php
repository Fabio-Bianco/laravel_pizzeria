<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Pomodoro', 'Mozzarella', 'Basilico', 'Funghi', 'Prosciutto', 'Peperoni', 'Olive', 'Carciofi', 'Cipolla', 'Aglio', 'Acciughe', 'Tonno', 'Uova', 'Salame', 'Pancetta', 'Rucola', 'Grana', 'Zucchine', 'Melanzane', 'Salsiccia'
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
