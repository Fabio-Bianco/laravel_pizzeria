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
            'description' => $this->description,
            'slug'        => $this->slug,
            'price'       => $this->price,
            'is_vegan'    => $this->is_vegan,
            'is_gluten_free' => (bool) ($this->is_gluten_free ?? false),
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
            // URL immagine
            'image_url' => (function () {
                $imgName = strtolower(str_replace([' ', "'"], ['-', ''], $this->name)) . '.jpeg';
                $imgPath = 'img/appetizers/' . $imgName;
                if (file_exists(public_path($imgPath))) {
                    return asset($imgPath);
                }
                return asset('img/appetizers/default.jpg');
            })(),
            'image_debug_name' => strtolower(str_replace([' ', "'"], ['-', ''], $this->name)) . '.jpeg',
        ];
    }
}
