<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Allergen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\AllergenResource;

class AllergenController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 50);
        $paginator = Allergen::select('id','name','slug')
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
            'data'  => AllergenResource::collection($paginator->getCollection()),
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
        ]);
        $data['slug'] = Str::slug($data['name']);
        $allergen = Allergen::create($data);
        return response()->json($allergen, 201);
    }

    public function show(Allergen $allergen)
    {
        return AllergenResource::make($allergen)->response();
    }

    public function update(Request $request, Allergen $allergen)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $data['slug'] = Str::slug($data['name']);
        $allergen->update($data);
        return $allergen;
    }

    public function destroy(Allergen $allergen)
    {
        $allergen->delete();
        return response()->noContent();
    }
}
