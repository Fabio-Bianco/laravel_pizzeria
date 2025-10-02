<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppetizerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'price'       => $this->price,
            'description' => $this->when($this->description !== null, $this->description),
            'notes'       => $this->when($this->description !== null, $this->description), // alias per compatibilità
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients')),
            // Allergeni intelligenti (automatici + manuali)
            'allergens'   => $this->when(
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
        ];
    }
}
