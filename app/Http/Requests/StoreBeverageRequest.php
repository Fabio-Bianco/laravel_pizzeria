<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBeverageRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('beverages', 'name')],
            'description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0', 'max:99.99'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Il nome della bevanda è obbligatorio.',
            'name.unique' => 'Esiste già una bevanda con questo nome.',
            'price.required' => 'Il prezzo è obbligatorio.',
            'price.min' => 'Il prezzo deve essere maggiore di zero.',
            'price.max' => 'Il prezzo non può superare 99.99 euro.',
        ];
    }
}
