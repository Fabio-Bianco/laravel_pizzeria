<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDessertRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array
    {
        $dessertId = $this->route('dessert')->id ?? $this->route('dessert');
        
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('desserts', 'name')->ignore($dessertId)],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0', 'max:999.99'],
            'ingredients' => ['array'],
            'ingredients.*' => ['integer', 'exists:ingredients,id'],
            'manual_allergens' => ['array'],
            'manual_allergens.*' => ['integer', 'exists:allergens,id'],
            'is_vegan' => ['boolean'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.image' => 'Il file caricato deve essere un\'immagine.',
            'image.mimes' => 'L\'immagine deve essere in formato JPG, JPEG, PNG o WEBP.',
            'image.max' => 'L\'immagine non pu\' superare i 2MB.',
            'name.required' => 'Il nome del dessert è obbligatorio.',
            'name.unique' => 'Esiste già un dessert con questo nome.',
            'price.required' => 'Il prezzo è obbligatorio.',
            'price.min' => 'Il prezzo deve essere maggiore di zero.',
            'price.max' => 'Il prezzo non può superare 999.99 euro.',
            'ingredients.*.exists' => 'Uno o più ingredienti selezionati non sono validi.',
        ];
    }
}
