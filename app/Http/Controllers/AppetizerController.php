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
        \DB::enableQueryLog();
        $query = Appetizer::query()
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

        $appetizers = $query->paginate(10)->withQueryString();

        $filters = \Cache::remember('admin.appetizer.filters', 600, function () {
            return [
                'ingredients' => Ingredient::orderBy('name')->pluck('name', 'id'),
                'allergens'   => Allergen::orderBy('name')->pluck('name', 'id'),
            ];
        });

        foreach (\DB::getQueryLog() as $query) {
            if (($query['time'] ?? 0) > 100) {
                \Log::warning('Query lenta AppetizerController@index', $query);
            }
        }

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

    /**
     * Genera uno slug unico per l'antipasto
     */
    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;
        while (
            Appetizer::where('slug', $slug)
                ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }
}
