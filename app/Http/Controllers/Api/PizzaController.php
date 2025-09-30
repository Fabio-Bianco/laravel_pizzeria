<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PizzaController extends Controller
{
    public function index()
    {
        return Pizza::with(['category', 'ingredients'])->latest()->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'ingredients' => ['array'],
            'ingredients.*' => ['integer', 'exists:ingredients,id'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $pizza = Pizza::create($data);
        $pizza->ingredients()->sync($request->input('ingredients', []));
        return response()->json($pizza->load(['category', 'ingredients']), 201);
    }

    public function show(Pizza $pizza)
    {
        return $pizza->load(['category', 'ingredients']);
    }

    public function update(Request $request, Pizza $pizza)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'ingredients' => ['array'],
            'ingredients.*' => ['integer', 'exists:ingredients,id'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $pizza->update($data);
        $pizza->ingredients()->sync($request->input('ingredients', []));
        return $pizza->load(['category', 'ingredients']);
    }

    public function destroy(Pizza $pizza)
    {
        $pizza->delete();
        return response()->noContent();
    }
}
