<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBeverageRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array
    {
        $id = $this->route('beverage')->id;
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('beverages', 'name')->ignore($id)],
            'description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0', 'max:99.99'],
            'formato' => ['nullable', 'string', 'max:50'],
            'tipologia' => ['nullable', 'string', 'max:50'],
            'gradazione_alcolica' => ['nullable', 'numeric', 'min:0', 'max:99.9'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.image' => 'Il file caricato deve essere un\'immagine.',
            'image.mimes' => 'L\'immagine deve essere in formato JPG, JPEG, PNG o WEBP.',
            'image.max' => 'L\'immagine non pu\' superare i 2MB.',
            'name.required' => 'Il nome della bevanda è obbligatorio.',
            'name.unique' => 'Esiste già una bevanda con questo nome.',
            'price.required' => 'Il prezzo è obbligatorio.',
            'price.min' => 'Il prezzo deve essere maggiore di zero.',
            'price.max' => 'Il prezzo non può superare 99.99 euro.',
        ];
    }
}
