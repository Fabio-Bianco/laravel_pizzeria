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
            // URL immagine
            'image_url' => (function () {
                $imgName = strtolower(str_replace([' ', "'"], ['-', ''], $this->name)) . '.jpeg';
                $imgPath = 'img/beverages/' . $imgName;
                if (file_exists(public_path($imgPath))) {
                    return asset($imgPath);
                }
                return asset('img/beverages/default.jpg');
            })(),
            'image_debug_name' => strtolower(str_replace([' ', "'"], ['-', ''], $this->name)) . '.jpeg',
        ];
    }
}
