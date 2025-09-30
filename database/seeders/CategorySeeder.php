<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Classiche', 'description' => 'Le pizze più amate'],
            ['name' => 'Bianche', 'description' => 'Senza pomodoro'],
            ['name' => 'Speciali', 'description' => 'Combinazioni gourmet'],
        ];
        foreach ($items as $it) {
            Category::firstOrCreate(
                ['slug' => Str::slug($it['name'])],
                ['name' => $it['name'], 'description' => $it['description'] ?? null]
            );
        }
    }
}
