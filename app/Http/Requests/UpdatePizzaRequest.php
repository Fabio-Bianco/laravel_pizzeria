<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePizzaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('pizza')->id;
        return [
            'name' => ['required','string','max:255', Rule::unique('pizzas','name')->ignore($id)],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'category_id' => ['nullable','integer','exists:categories,id'],
            'ingredients' => ['array'],
            'ingredients.*' => ['integer','exists:ingredients,id'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];
    }
}
