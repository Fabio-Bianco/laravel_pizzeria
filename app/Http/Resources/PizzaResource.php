<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PizzaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,
            'slug'              => $this->slug,
            'price'             => $this->price,
            'notes'             => $this->notes,
            'is_vegan'          => $this->is_vegan,
            'is_gluten_free'    => (bool) ($this->is_gluten_free ?? false),
            'ingredients_count' => $this->when(isset($this->ingredients_count), (int) $this->ingredients_count),
            'category'          => new CategoryResource($this->whenLoaded('category')),
            'ingredients'       => IngredientResource::collection($this->whenLoaded('ingredients')),
            // Allergeni intelligenti (automatici + manuali)
            'allergens'         => $this->when(
                $this->relationLoaded('ingredients'),
                fn() => AllergenResource::collection($this->getAllAllergens())
            ),
            // Breakdown allergeni per debug/admin
            'automatic_allergens' => $this->when(
                $request->has('include_allergen_breakdown'),
                fn() => AllergenResource::collection($this->getAutomaticAllergens())
            ),
            'manual_allergens' => $this->when(
                $request->has('include_allergen_breakdown'),
                fn() => AllergenResource::collection($this->getManualAllergens())
            ),
            // URL immagine sempre come stringa valida
            'image_url' => (function () {
                $pizzaName = strtolower(str_replace([' ', "'"], ['-', ''], $this->name));
                $imgMap = [
                    'capricciosa' => 'capricciosa.jpg',
                    'margherita' => 'margherita.jpg',
                    'quattro-formaggi' => 'quattro-formaggi.jpg',
                ];
                $imgFile = $imgMap[$pizzaName] ?? null;
                if ($imgFile && file_exists(public_path('img/pizzas/' . $imgFile))) {
                    return asset('img/pizzas/' . $imgFile);
                }
                return asset('img/pizzas/default.jpg');
            })(),
            // Se vuoi invece un oggetto: 'image' => [ 'url' => ... ]
        ];
    }
}
