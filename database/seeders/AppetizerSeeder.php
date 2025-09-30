<?php

namespace Database\Seeders;

use App\Models\Appetizer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AppetizerSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Bruschette', 'price' => 4.50, 'description' => 'Pane tostato, pomodoro, basilico.'],
            ['name' => 'Olive all’Ascolana', 'price' => 5.50, 'description' => 'Olive ripiene fritte.'],
            ['name' => 'Fritto misto', 'price' => 6.50, 'description' => 'Supplì, crocchette, anelli di cipolla.'],
        ];

        foreach ($items as $item) {
            Appetizer::firstOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'description' => $item['description'],
                ]
            );
        }
    }
}
