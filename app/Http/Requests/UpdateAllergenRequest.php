<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAllergenRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array
    {
        $id = $this->route('allergen')->id;
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('allergens', 'name')->ignore($id)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Il nome dell\'allergene è obbligatorio.',
            'name.unique' => 'Esiste già un allergene con questo nome.',
        ];
    }
}
