<?php

namespace Database\Factories;

use App\Models\Beverage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<App\Models\Beverage>
 */
class BeverageFactory extends Factory
{
    protected $model = Beverage::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name.'-'.Str::random(5)),
            'price' => $this->faker->randomFloat(2, 1, 8),
            'description' => $this->faker->optional()->sentence(),
        ];
    }
}
