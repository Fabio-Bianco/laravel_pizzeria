<?php

namespace Database\Seeders;

use App\Models\Beverage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeverageSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Acqua naturale 0.5L', 'price' => 1.00, 'description' => null],
            ['name' => 'Acqua frizzante 0.5L', 'price' => 1.00, 'description' => null],
            ['name' => 'Bibita 0.33L', 'price' => 2.50, 'description' => 'Cola, aranciata, limonata'],
            ['name' => 'Birra 0.33L', 'price' => 3.50, 'description' => 'Chiara o rossa'],
        ];

        foreach ($items as $item) {
            Beverage::firstOrCreate(
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
