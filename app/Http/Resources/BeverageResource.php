<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeverageResource extends JsonResource
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
            'is_gluten_free' => (bool) ($this->is_gluten_free ?? false),
            'formato'     => $this->formato,
            'tipologia'   => $this->tipologia,
            'gradazione_alcolica' => $this->gradazione_alcolica,
        ];
    }
}
