<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDessertRequest;
use App\Http\Requests\UpdateDessertRequest;
use App\Models\Allergen;
use App\Models\Dessert;
use App\Models\Ingredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

class DessertController extends Controller
{
    public function index(Request $request): View
    {
        \DB::enableQueryLog();
        $q = Dessert::query()
            ->with(['ingredients:id,name'])
            ->withCount('ingredients')
            ->select(['id', 'name', 'slug', 'price', 'description'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = '%' . $request->string('search')->trim() . '%';
                $q->where(function ($w) use ($term) {
                    $w->where('name', 'like', $term)
                        ->orWhere('description', 'like', $term);
                });
            })
            ->when($request->filled('ingredient'), function ($q) use ($request) {
                $q->whereHas('ingredients', fn ($w) => $w->where('ingredients.id', $request->integer('ingredient')));
            })
            ->when($request->filled('sort'), function ($q) use ($request) {
                return match ($request->string('sort')->toString()) {
                    'price_asc'  => $q->orderBy('price', 'asc'),
                    'price_desc' => $q->orderBy('price', 'desc'),
                    'name_asc'   => $q->orderBy('name', 'asc'),
                    'name_desc'  => $q->orderBy('name', 'desc'),
                    default      => $q->latest('id'),
                };
            }, fn ($q) => $q->latest('id'));

        $desserts = $q->paginate(10)->withQueryString();

        $filters = \Cache::remember('admin.dessert.filters', 600, function () {
            return [
                'ingredients' => Ingredient::orderBy('name')->pluck('name', 'id'),
                'allergens'   => Allergen::orderBy('name')->pluck('name', 'id'),
            ];
        });

        foreach (\DB::getQueryLog() as $query) {
            if (($query['time'] ?? 0) > 100) {
                \Log::warning('Query lenta DessertController@index', $query);
            }
        }

        return view('admin.desserts.index', compact('desserts', 'filters'));
    }

    public function create(): View
    {
        $ingredients = Ingredient::orderBy('name')->get();
        $allergens = Allergen::orderBy('name')->get();
        return view('admin.desserts.create', compact('ingredients', 'allergens'));
    }

    public function store(StoreDessertRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->generateUniqueSlug($data['name']);
    $data['is_gluten_free'] = $request->has('is_gluten_free');
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('desserts', 'public');
        }
        $dessert = Dessert::create($data);
        $dessert->ingredients()->sync($request->input('ingredients', []));
        return redirect()->route('admin.desserts.index')->with('status', 'Dessert creato.');
    }

    public function show(Dessert $dessert): View
    {
        $dessert->load('ingredients');
        return view('admin.desserts.show', compact('dessert'));
    }

    public function edit(Dessert $dessert): View
    {
        $categories = \App\Models\Category::all()->sortBy(function($cat) {
            if (strtolower($cat->name) === 'classiche') return 0;
            if ($cat->is_white) return 1;
            if (strtolower($cat->name) === 'speciali') return 2;
            return 3;
        })->values();
        $ingredients = Ingredient::orderBy('name')->get();
        $allergens = Allergen::orderBy('name')->get();
        $dessert->load(['ingredients', 'allergens']);
        return view('admin.desserts.edit', compact('dessert', 'categories', 'ingredients', 'allergens'));
    }

    public function update(UpdateDessertRequest $request, Dessert $dessert): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->generateUniqueSlug($data['name'], $dessert->id);
    $data['is_gluten_free'] = $request->has('is_gluten_free');
        if ($request->hasFile('image')) {
            if ($dessert->image_path) {
                \Storage::disk('public')->delete($dessert->image_path);
            }
            $data['image_path'] = $request->file('image')->store('desserts', 'public');
        }
        $dessert->update($data);
        $dessert->ingredients()->sync($request->input('ingredients', []));
        return redirect()->route('admin.desserts.index')->with('status', 'Dessert aggiornato.');
    }

    public function destroy(Dessert $dessert): RedirectResponse
    {
        if ($dessert->image_path) {
            \Storage::disk('public')->delete($dessert->image_path);
        }
        $dessert->delete();
        return redirect()->route('admin.desserts.index')->with('status', 'Dessert eliminato.');
    }

    /**
     * Genera uno slug unico per il dessert
     */
    private function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;
        while (true) {
            $query = Dessert::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            if (!$query->exists()) {
                break;
            }
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }
}
