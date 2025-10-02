<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIngredientRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('ingredients', 'name')],
            'allergens' => ['array'],
            'allergens.*' => ['integer', 'exists:allergens,id'],
            'is_tomato' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Il nome dell\'ingrediente è obbligatorio.',
            'name.unique' => 'Esiste già un ingrediente con questo nome.',
            'allergens.*.exists' => 'Uno o più allergeni selezionati non sono validi.',
        ];
    }
}
