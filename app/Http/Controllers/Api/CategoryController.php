<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 50);
        $paginator = Category::select('id','name','slug')
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
            'data'  => CategoryResource::collection($paginator->getCollection()),
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
        ]);
        $data['slug'] = Str::slug($data['name']);
        $category = Category::create($data);
        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        return CategoryResource::make($category)->response();
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);
        $data['slug'] = Str::slug($data['name']);
        $category->update($data);
        return $category;
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
