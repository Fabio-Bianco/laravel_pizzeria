<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'slug'      => $this->slug,
            'is_tomato' => (bool) $this->is_tomato,
            // Nessun campo pivot esposto; relazioni annidate semplificate
            'allergens' => AllergenResource::collection($this->whenLoaded('allergens')),
        ];
    }
}
