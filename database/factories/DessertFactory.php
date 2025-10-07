<?php

namespace Database\Factories;

use App\Models\Dessert;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dessert>
 */
class DessertFactory extends Factory
{
    protected $model = Dessert::class;

    /**
     * Lista di dessert italiani tipici
     */
    private static $dessertNames = [
        'Tiramisù',
        'Panna Cotta',
        'Cannoli Siciliani',
        'Gelato Artigianale',
        'Semifreddo ai Frutti di Bosco',
        'Cheesecake ai Mirtilli',
        'Crème Brûlée',
        'Mousse al Cioccolato',
        'Profiteroles',
        'Millefoglie',
        'Sorbetto al Limone',
        'Crostata della Nonna',
        'Babà al Rum',
        'Cassata Siciliana',
        'Affogato al Caffè',
        'Panna Cotta ai Frutti Rossi',
        'Gelato al Pistacchio',
        'Torta della Nonna',
        'Sacher Torte',
        'Brownies al Cioccolato'
    ];

    /**
     * Descrizioni creative per i dessert
     */
    private static $descriptions = [
        'Un classico della pasticceria italiana, preparato con ingredienti freschi e di qualità',
        'Delicato e cremoso, perfetto per concludere una cena in dolcezza',
        'La tradizione incontra il gusto in questo dessert irresistibile',
        'Preparato secondo l\'antica ricetta della nonna, con amore e passione',
        'Un\'esplosione di sapori che conquisterà il vostro palato',
        'Fresco e leggero, ideale per ogni stagione',
        'La dolcezza perfetta per i veri intenditori',
        'Un capolavoro della pasticceria che non potete perdere',
        'Ingredienti selezionati e lavorazione artigianale per un risultato unico',
        'Il dessert che renderà speciale la vostra serata'
    ];

    public function definition(): array
    {
        static $usedNames = [];
        
        // Seleziona un nome non ancora usato
        do {
            $name = fake()->randomElement(self::$dessertNames);
        } while (in_array($name, $usedNames));
        
        $usedNames[] = $name;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->randomElement(self::$descriptions),
            'price' => fake()->randomFloat(2, 4.50, 12.90), // Prezzi realistici per dessert
            'is_vegan' => fake()->boolean(20), // 20% di probabilità di essere vegano
            'manual_allergens' => null, // Inizialmente null, li aggiungeremo via seeder se necessario
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Factory state per dessert con allergeni manuali
     */
    public function withManualAllergens(): static
    {
        return $this->state(function (array $attributes) {
            // Alcuni dessert possono avere allergeni specifici non derivati dagli ingredienti
            $manualAllergenIds = fake()->randomElements([1, 2, 3, 7], fake()->numberBetween(0, 2));
            
            return [
                'manual_allergens' => empty($manualAllergenIds) ? null : $manualAllergenIds,
            ];
        });
    }

    /**
     * Factory state per dessert premium (prezzi più alti)
     */
    public function premium(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'price' => fake()->randomFloat(2, 8.50, 15.90),
            ];
        });
    }

    /**
     * Factory state per dessert classici (prezzi accessibili)
     */
    public function classic(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'price' => fake()->randomFloat(2, 3.50, 7.90),
            ];
        });
    }
}