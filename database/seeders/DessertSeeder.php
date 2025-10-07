<?php

namespace Database\Seeders;

use App\Models\Dessert;
use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DessertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verifica se ci sono già dessert nel database
        if (Dessert::count() > 0) {
            $this->command->info('Dessert già presenti nel database. Saltando il seeding...');
            return;
        }

        $this->command->info('🍰 Creazione dessert con Faker...');

        // Ottieni alcuni ingredienti esistenti per associarli ai dessert
        $ingredients = Ingredient::all();
        
        if ($ingredients->isEmpty()) {
            $this->command->warn('⚠️  Nessun ingrediente trovato. Assicurati di aver eseguito IngredientSeeder prima.');
        }

        // Crea 15 dessert usando il factory
        $desserts = Dessert::factory()
            ->count(15)
            ->create();

        $this->command->info("✅ Creati {$desserts->count()} dessert:");

        // Associa ingredienti casuali ad alcuni dessert
        foreach ($desserts as $index => $dessert) {
            // Solo per alcuni dessert aggiungiamo ingredienti (circa il 60%)
            if ($ingredients->isNotEmpty() && fake()->boolean(60)) {
                // Seleziona 1-4 ingredienti casuali per ogni dessert
                $randomIngredients = $ingredients->random(fake()->numberBetween(1, 4));
                $dessert->ingredients()->attach($randomIngredients->pluck('id'));
                
                $this->command->line("  🍰 {$dessert->name} (€{$dessert->price}) - con " . $randomIngredients->count() . " ingredienti");
            } else {
                $this->command->line("  🍰 {$dessert->name} (€{$dessert->price})");
            }
        }

        // Crea alcuni dessert premium
        $premiumDesserts = Dessert::factory()
            ->premium()
            ->withManualAllergens()
            ->count(3)
            ->create();

        foreach ($premiumDesserts as $dessert) {
            $this->command->line("  ⭐ {$dessert->name} (€{$dessert->price}) - Premium");
        }

        // Crea alcuni dessert classici economici
        $classicDesserts = Dessert::factory()
            ->classic()
            ->count(2)
            ->create();

        foreach ($classicDesserts as $dessert) {
            $this->command->line("  💝 {$dessert->name} (€{$dessert->price}) - Classico");
        }

        $totalDesserts = Dessert::count();
        $this->command->info("🎉 Seeding completato! Totale dessert: {$totalDesserts}");
    }
}
