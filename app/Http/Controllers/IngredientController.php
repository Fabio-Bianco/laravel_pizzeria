<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Models\Allergen;
use App\Models\Ingredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class IngredientController extends Controller
{
    public function index(Request $request): View
    {
        \DB::enableQueryLog();
        if ($request->query()) {
            session(['ingredients.index.query' => $request->query()]);
        }
        $q = Ingredient::query()
            ->with(['allergens:id,name'])
            ->withCount('pizzas')
            ->select(['id','name','slug'])
            ->when($request->filled('search'), function ($qq) use ($request) {
                $term = '%'.$request->string('search')->trim().'%';
                $qq->where('name', 'like', $term);
            })
            ->when($request->filled('allergen'), function ($qq) use ($request) {
                $allergenId = $request->integer('allergen');
                $qq->whereHas('allergens', fn($w) => $w->where('allergens.id', $allergenId));
            })
            ->when($request->filled('sort'), function ($qq) use ($request) {
                return match ($request->string('sort')->toString()) {
                    'name_asc'   => $qq->orderBy('name', 'asc'),
                    'name_desc'  => $qq->orderBy('name', 'desc'),
                    default      => $qq->latest('id'),
                };
            }, fn($qq) => $qq->latest('id'));

        $ingredients = $q->paginate(10)->withQueryString();

        $filters = \Cache::remember('admin.ingredient.filters', 600, function () {
            return [
                'allergens' => Allergen::orderBy('name')->pluck('name','id'),
            ];
        });

        foreach (\DB::getQueryLog() as $query) {
            if (($query['time'] ?? 0) > 100) {
                \Log::warning('Query lenta IngredientController@index', $query);
            }
        }

        return view('admin.ingredients.index', compact('ingredients','filters'));
    }

    public function create(): View
    {
        $allergens = Allergen::orderBy('name')->get();
        return view('admin.ingredients.create', compact('allergens'));
    }

    public function store(StoreIngredientRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $data['is_tomato'] = $request->boolean('is_tomato');

        $ingredient = Ingredient::create($data);
        $ingredient->allergens()->sync($request->input('allergens', []));

        if ($request->wantsJson()) {
            return response()->json([
                'id' => $ingredient->id,
                'name' => $ingredient->name,
            ], 201);
        }

        $qs = session('ingredients.index.query', []);
        return redirect()->route('admin.ingredients.index', $qs)->with('status', 'Ingrediente creato.');
    }

    public function show(Ingredient $ingredient): View
    {
        $ingredient->load('allergens');
        return view('admin.ingredients.show', compact('ingredient'));
    }

    public function edit(Ingredient $ingredient): View
    {
        $allergens = Allergen::orderBy('name')->get();
        $ingredient->load('allergens');
        return view('admin.ingredients.edit', compact('ingredient', 'allergens'));
    }

    public function update(UpdateIngredientRequest $request, Ingredient $ingredient): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $data['is_tomato'] = $request->boolean('is_tomato');

        $ingredient->update($data);
        $ingredient->allergens()->sync($request->input('allergens', []));

    $qs = session('ingredients.index.query', []);
    return redirect()->route('admin.ingredients.index', $qs)->with('status', 'Ingrediente aggiornato.');
    }

    public function destroy(Ingredient $ingredient): RedirectResponse
    {
        $ingredient->delete();
    $qs = session('ingredients.index.query', []);
    return redirect()->route('admin.ingredients.index', $qs)->with('status', 'Ingrediente eliminato.');
    }

    /**
     * AJAX: Ottieni allergeni per una lista di ingredienti (per form intelligenti)
     */
    public function getAllergensForIngredients(Request $request)
    {
        $ingredientIds = $request->input('ingredient_ids', []);
        
        if (empty($ingredientIds)) {
            return response()->json(['allergens' => []]);
        }

        $allergens = Allergen::whereHas('ingredients', function($query) use ($ingredientIds) {
            $query->whereIn('ingredients.id', $ingredientIds);
        })->get(['id', 'name'])->unique('id');

        return response()->json(['allergens' => $allergens]);
    }
}
