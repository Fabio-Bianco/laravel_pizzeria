<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\PizzaResource;

class PizzaController extends Controller
{
    /**
     * Elenco pizze in JSON per frontend React.
     * Supporta filtri e paginazione e restituisce struttura { data, meta, links }.
     */
    public function index(Request $request)
    {
        $query = Pizza::query()
            ->with(['category:id,name,slug', 'ingredients.allergens'])
            ->withCount('ingredients')
            ->when($request->filled('search'), function ($builder) use ($request) {
                $term = '%'.$request->string('search')->trim().'%';
                $builder->where(function ($w) use ($term) {
                    $w->where('name', 'like', $term)
                      ->orWhere('notes', 'like', $term);
                });
            })
            ->when($request->filled('category'), function ($builder) use ($request) {
                $builder->where('category_id', $request->integer('category'));
            })
            ->when($request->filled('ingredient'), function ($builder) use ($request) {
                $ingredientId = $request->integer('ingredient');
                $builder->whereHas('ingredients', function ($nested) use ($ingredientId) {
                    $nested->where('ingredients.id', $ingredientId);
                });
            })
            ->when($request->filled('sort'), function ($builder) use ($request) {
                return match ($request->string('sort')->toString()) {
                    'price_asc'  => $builder->orderBy('price', 'asc'),
                    'price_desc' => $builder->orderBy('price', 'desc'),
                    'name_asc'   => $builder->orderBy('name', 'asc'),
                    'name_desc'  => $builder->orderBy('name', 'desc'),
                    default      => $builder->latest('id'),
                };
            }, function ($builder) {
                return $builder->latest('id');
            });

        $perPage = min(max((int) $request->query('per_page', 10), 1), 50);
        $paginator = $query->paginate($perPage)->appends($request->query());

        return response()->json([
            'data'  => PizzaResource::collection($paginator->getCollection()),
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
    $pizza->load(['category:id,name,slug', 'ingredients.allergens']);
    return PizzaResource::make($pizza)->response();
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
