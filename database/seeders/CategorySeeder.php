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
            ['name' => 'Classiche', 'description' => 'Le pizze più amate', 'is_white' => false],
            ['name' => 'Bianche',   'description' => 'Senza pomodoro',     'is_white' => true],
            ['name' => 'Speciali',  'description' => 'Combinazioni gourmet','is_white' => false],
        ];
        foreach ($items as $it) {
            Category::updateOrCreate(
                ['slug' => Str::slug($it['name'])],
                ['name' => $it['name'], 'description' => $it['description'] ?? null, 'is_white' => $it['is_white'] ?? false]
            );
        }
    }
}
