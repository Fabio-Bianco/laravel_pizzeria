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
        $q = Dessert::query()
            ->with('ingredients')
            ->withCount('ingredients')
            ->when($request->filled('search'), function ($qq) use ($request) {
                $term = '%'.$request->string('search')->trim().'%';
                $qq->where(function ($w) use ($term) {
                    $w->where('name', 'like', $term)
                      ->orWhere('description', 'like', $term);
                });
            })
            ->when($request->filled('ingredient'), function ($qq) use ($request) {
                $qq->whereHas('ingredients', fn($w) => $w->where('ingredients.id', $request->integer('ingredient')));
            })
            ->when($request->filled('sort'), function ($qq) use ($request) {
                return match ($request->string('sort')->toString()) {
                    'price_asc'  => $qq->orderBy('price', 'asc'),
                    'price_desc' => $qq->orderBy('price', 'desc'),
                    'name_asc'   => $qq->orderBy('name', 'asc'),
                    'name_desc'  => $qq->orderBy('name', 'desc'),
                    default      => $qq->latest('id'),
                };
            }, fn($qq) => $qq->latest('id'));

        $desserts = $q->paginate(10)->withQueryString();
        
        // Filtri per la vista
        $filters = [
            'ingredients' => Ingredient::orderBy('name')->pluck('name','id'),
        ];
        
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
        $ingredients = Ingredient::orderBy('name')->get();
        $allergens = Allergen::orderBy('name')->get();
        $dessert->load('ingredients');
        return view('admin.desserts.edit', compact('dessert', 'ingredients', 'allergens'));
    }

    public function update(UpdateDessertRequest $request, Dessert $dessert): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->generateUniqueSlug($data['name'], $dessert->id);
        
        $dessert->update($data);
        $dessert->ingredients()->sync($request->input('ingredients', []));
        
        return redirect()->route('admin.desserts.index')->with('status', 'Dessert aggiornato.');
    }

    public function destroy(Dessert $dessert): RedirectResponse
    {
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
