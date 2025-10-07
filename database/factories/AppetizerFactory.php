<?php

namespace Database\Factories;

use App\Models\Appetizer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<App\Models\Appetizer>
 */
class AppetizerFactory extends Factory
{
    protected $model = Appetizer::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name.'-'.Str::random(5)),
            'price' => $this->faker->randomFloat(2, 1, 15),
            'description' => $this->faker->optional()->sentence(),
            'is_vegan' => $this->faker->boolean(30), // 30% di probabilità di essere vegano
        ];
    }
}
