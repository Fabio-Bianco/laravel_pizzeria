<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AllergenSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\IngredientSeeder;
use Database\Seeders\PizzaSeeder;
use Database\Seeders\CustomUserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            CustomUserSeeder::class,
            CategorySeeder::class,
            AllergenSeeder::class,
            IngredientSeeder::class,
            PizzaSeeder::class,
        ]);
    }
}
