<?php

namespace Database\Factories;

use App\Models\Allergen;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AllergenFactory extends Factory
{
    protected $model = Allergen::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Glutine', 'Crostacei', 'Uova', 'Pesce', 'Arachidi', 'Soia', 'Latte', 'Frutta a guscio', 'Sedano', 'Senape', 'Sesamo', 'Anidride solforosa e solfiti', 'Lupini', 'Molluschi'
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}