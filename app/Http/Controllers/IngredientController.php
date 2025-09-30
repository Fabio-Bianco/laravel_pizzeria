<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use App\Models\Ingredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class IngredientController extends Controller
{
    public function index(): View
    {
        $ingredients = Ingredient::with('allergens')->latest()->paginate(10);
        return view('ingredients.index', compact('ingredients'));
    }

    public function create(): View
    {
        $allergens = Allergen::orderBy('name')->get();
        return view('ingredients.create', compact('allergens'));
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

        if ($request->wantsJson()) {
            return response()->json([
                'id' => $ingredient->id,
                'name' => $ingredient->name,
            ], 201);
        }

        return redirect()->route('admin.ingredients.index')->with('status', 'Ingrediente creato.');
    }

    public function show(Ingredient $ingredient): View
    {
        $ingredient->load('allergens');
        return view('ingredients.show', compact('ingredient'));
    }

    public function edit(Ingredient $ingredient): View
    {
        $allergens = Allergen::orderBy('name')->get();
        $ingredient->load('allergens');
        return view('ingredients.edit', compact('ingredient', 'allergens'));
    }

    public function update(Request $request, Ingredient $ingredient): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'allergens' => ['array'],
            'allergens.*' => ['integer', 'exists:allergens,id'],
        ]);
        $data['slug'] = Str::slug($data['name']);

        $ingredient->update($data);
        $ingredient->allergens()->sync($request->input('allergens', []));

    return redirect()->route('admin.ingredients.index')->with('status', 'Ingrediente aggiornato.');
    }

    public function destroy(Ingredient $ingredient): RedirectResponse
    {
        $ingredient->delete();
    return redirect()->route('admin.ingredients.index')->with('status', 'Ingrediente eliminato.');
    }
}
