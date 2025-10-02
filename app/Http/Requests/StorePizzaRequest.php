<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Ingredient;

class StorePizzaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255', Rule::unique('pizzas','name')],
            // description kept for backward compatibility but no longer used in forms
            'description' => ['nullable','string'],
            'notes' => ['nullable','string','max:500'],
            'price' => ['required','numeric','min:0'],
            'category_id' => ['nullable','integer','exists:categories,id'],
            'ingredients' => ['array'],
            'ingredients.*' => ['integer','exists:ingredients,id'],
            'manual_allergens' => ['array'],
            'manual_allergens.*' => ['integer','exists:allergens,id'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $categoryId = $this->input('category_id');
            $ingredientIds = (array) $this->input('ingredients', []);

            if (!$categoryId || empty($ingredientIds)) {
                return; // nothing to validate cross-field
            }

            // Apply rule only if selected category is flagged as white
            $isWhiteCategory = Category::whereKey($categoryId)->where('is_white', true)->exists();
            if (!$isWhiteCategory) {
                return; // rule applies only to white category
            }

            // Forbid any tomato ingredient when pizza is white
            $hasTomato = Ingredient::whereIn('id', $ingredientIds)->where('is_tomato', true)->exists();
            if ($hasTomato) {
                $validator->errors()->add('ingredients', 'Le pizze bianche non possono contenere pomodoro.');
            }
        });
    }
}
