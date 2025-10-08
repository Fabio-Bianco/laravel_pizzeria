<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppetizerRequest;
use App\Http\Requests\UpdateAppetizerRequest;
use App\Models\Allergen;
use App\Models\Appetizer;
use App\Models\Ingredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AppetizerController extends Controller
{
    public function index(Request $request): View
    {
        $q = Appetizer::query()
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

        $appetizers = $q->paginate(10)->withQueryString();
        
        // Filtri per la vista
        $filters = [
            'ingredients' => Ingredient::orderBy('name')->pluck('name','id'),
        ];
        
        return view('admin.appetizers.index', compact('appetizers', 'filters'));
    }

    public function create(): View
    {
        $ingredients = Ingredient::orderBy('name')->get();
        $allergens = Allergen::orderBy('name')->get();
        return view('admin.appetizers.create', compact('ingredients', 'allergens'));
    }

    public function store(StoreAppetizerRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->generateUniqueSlug($data['name']);
        
        $appetizer = Appetizer::create($data);
        $appetizer->ingredients()->sync($request->input('ingredients', []));
        
        return redirect()->route('admin.appetizers.index')->with('status', 'Antipasto creato.');
    }

    public function show(Appetizer $appetizer): View
    {
        $appetizer->load('ingredients');
        return view('admin.appetizers.show', compact('appetizer'));
    }

    public function edit(Appetizer $appetizer): View
    {
    $ingredients = Ingredient::orderBy('name')->get();
    $allergens = Allergen::orderBy('name')->get();
    $appetizer->load(['ingredients', 'allergens']);
    return view('admin.appetizers.edit', compact('appetizer', 'ingredients', 'allergens'));
    }

    public function update(UpdateAppetizerRequest $request, Appetizer $appetizer): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->generateUniqueSlug($data['name'], $appetizer->id);
        
        $appetizer->update($data);
        $appetizer->ingredients()->sync($request->input('ingredients', []));
        
        return redirect()->route('admin.appetizers.index')->with('status', 'Antipasto aggiornato.');
    }

    public function destroy(Appetizer $appetizer): RedirectResponse
    {
        $appetizer->delete();
        return redirect()->route('admin.appetizers.index')->with('status', 'Antipasto eliminato.');
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $suffixCounter = 2;
        while (
            Appetizer::where('slug', $slug)
                ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$suffixCounter;
            $suffixCounter++;
        }
        return $slug;
    }
}
