<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\IngredientResource;

class IngredientController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 50);
        $paginator = Ingredient::with('allergens')
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = '%'.$request->string('search')->trim().'%';
                $q->where('name', 'like', $term);
            })
            ->when($request->filled('sort'), function ($q) use ($request) {
                return match ($request->string('sort')->toString()) {
                    'name_desc' => $q->orderBy('name', 'desc'),
                    default     => $q->orderBy('name', 'asc'),
                };
            }, fn($q) => $q->orderBy('name', 'asc'))
            ->paginate($perPage)
            ->appends($request->query());

        return response()->json([
            'data'  => IngredientResource::collection($paginator->getCollection()),
            'meta'  => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ],
            'links' => [
                'first' => $paginator->url(1),
                'last'  => $paginator->url($paginator->lastPage()),
                'prev'  => $paginator->previousPageUrl(),
                'next'  => $paginator->nextPageUrl(),
            ],
        ]);
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
        $ingredient->load('allergens');
        return IngredientResource::make($ingredient)->response();
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
