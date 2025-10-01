<?php

namespace Database\Factories;

use App\Models\Pizza;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PizzaFactory extends Factory
{
    protected $model = Pizza::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'category_id' => null, // verrà associata nel seeder se necessario
            'name' => $name,
            'slug' => Str::slug($name),
            'price' => $this->faker->randomFloat(2, 5, 30),
            // column description removed from schema
            'notes' => $this->faker->optional(0.3)->sentence(6),
        ];
    }
}