<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dessert;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\DessertResource;

class DessertController extends Controller
{
    /**
     * Elenco dessert in JSON per frontend React.
     * Supporta filtri e paginazione e restituisce struttura { data, meta, links }.
     */
    public function index(Request $request)
    {
        try {
            $perPage = min(max((int) $request->query('per_page', 10), 1), 50);
            $with = ['ingredients'];
            if ($request->filled('with') && in_array('allergens', (array) $request->input('with'))) {
                $with[] = 'ingredients.allergens';
            }
            $cacheKey = 'api.desserts.' . md5(json_encode($request->query()));
            $result = \Cache::remember($cacheKey, 30, function () use ($request, $perPage, $with) {
                $query = Dessert::query()
                    ->with($with)
                    ->withCount('ingredients')
                    ->when($request->filled('search'), function ($builder) use ($request) {
                        $term = '%'.$request->string('search')->trim().'%';
                        $builder->where(function ($w) use ($term) {
                            $w->where('name', 'like', $term)
                              ->orWhere('description', 'like', $term);
                        });
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

                $paginator = $query->paginate($perPage)->appends($request->query());

                return [
                    'data'  => DessertResource::collection($paginator->getCollection()),
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
                ];
            });
            return response()->json($result);
        } catch (\Throwable $e) {
            \Log::error('API DessertController@index', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 'Errore interno server. Riprova più tardi.',
                'error' => app()->environment('production') ? null : $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'ingredients' => ['array'],
            'ingredients.*' => ['integer', 'exists:ingredients,id'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $dessert = Dessert::create($data);
        $dessert->ingredients()->sync($request->input('ingredients', []));
        return response()->json($dessert->load(['ingredients']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dessert $dessert)
    {
        $dessert->load(['ingredients.allergens']);
        return DessertResource::make($dessert)->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dessert $dessert)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'ingredients' => ['array'],
            'ingredients.*' => ['integer', 'exists:ingredients,id'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $dessert->update($data);
        $dessert->ingredients()->sync($request->input('ingredients', []));
        return $dessert->load(['ingredients']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dessert $dessert)
    {
        $dessert->delete();
        return response()->noContent();
    }
}
