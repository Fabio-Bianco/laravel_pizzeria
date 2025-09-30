<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IngredientController extends Controller
{
    public function index()
    {
        return Ingredient::with('allergens')->latest()->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'allergens' => ['array'],
            'allergens.*' => ['integer', 'exists:allergens,id'],
        ]);
        $data['slug'] = Str::slug($data['name']);

        $ingredient = Ingredient::create($data);
        $ingredient->allergens()->sync($request->input('allergens', []));

        return response()->json($ingredient->load('allergens'), 201);
    }

    public function show(Ingredient $ingredient)
    {
        return $ingredient->load('allergens');
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'allergens' => ['array'],
            'allergens.*' => ['integer', 'exists:allergens,id'],
        ]);
        $data['slug'] = Str::slug($data['name']);

        $ingredient->update($data);
        $ingredient->allergens()->sync($request->input('allergens', []));

        return $ingredient->load('allergens');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return response()->noContent();
    }
}
