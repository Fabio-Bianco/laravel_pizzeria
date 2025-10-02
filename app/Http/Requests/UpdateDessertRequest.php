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
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Il nome del dessert è obbligatorio.',
            'name.unique' => 'Esiste già un dessert con questo nome.',
            'price.required' => 'Il prezzo è obbligatorio.',
            'price.min' => 'Il prezzo deve essere maggiore di zero.',
            'price.max' => 'Il prezzo non può superare 999.99 euro.',
            'ingredients.*.exists' => 'Uno o più ingredienti selezionati non sono validi.',
        ];
    }
}
