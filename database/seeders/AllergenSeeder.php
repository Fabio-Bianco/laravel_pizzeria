<?php

namespace Database\Seeders;

use App\Models\Allergen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AllergenSeeder extends Seeder
{
    public function run(): void
    {
        $items = ['Glutine', 'Lattosio', 'Noci', 'Uova'];
        foreach ($items as $name) {
            Allergen::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
