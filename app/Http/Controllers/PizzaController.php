<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePizzaRequest;
use App\Http\Requests\UpdatePizzaRequest;
use App\Models\Allergen;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Pizza;
use App\Support\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

/**
 * Controller CRUD per la risorsa Pizza.
 *
 * Nota generale:
 * - Usiamo Eloquent per caricare relazioni (category, ingredients, allergens) in modo eager per evitare N+1.
 * - Filtri e ordinamenti sono applicati via query string (search, category, ingredient, sort).
 * - Le relazioni many-to-many (ingredienti) vengono allineate con sync() dopo store/update.
 */
class PizzaController extends Controller
{
    /**
     * Elenco pizze con filtri, ordinamenti e paginazione.
     * 🚀 OTTIMIZZATO: eager loading completo e caching intelligente
     *
     * Filtri supportati via query string:
     * - search: testo su name/notes
     * - category: id categoria esatta
     * - ingredient: id ingrediente contenuto nella pizza
     * - sort: price_asc|price_desc|name_asc|name_desc (default: recenti)
     */
    public function index(Request $request): View
    {
        // 🚀 OTTIMIZZAZIONE: Eager loading più completo per evitare N+1 queries
        $q = Pizza::query()
            ->with([
                'category:id,name', // Solo campi necessari
                'ingredients:id,name', // Solo campi necessari per ingredienti
                'ingredients.allergens:id,name' // Allergeni degli ingredienti (senza icon)
            ])
            ->withCount('ingredients')
            // Ricerca LIKE su name e notes
            ->when($request->filled('search'), function ($qq) use ($request) {
                $term = '%'.$request->string('search')->trim().'%';
                $qq->where(function ($w) use ($term) {
                    $w->where('name', 'like', $term)
                      ->orWhere('notes', 'like', $term);
                });
            })
            // Filtro per categoria esatta
            ->when($request->filled('category'), fn($qq) =>
                $qq->where('category_id', $request->integer('category')))
            // Filtro per ingrediente contenuto
            ->when($request->filled('ingredient'), fn($qq) =>
                $qq->whereHas('ingredients', fn($w) => $w->where('ingredients.id', $request->integer('ingredient'))))
            ->when($request->filled('sort'), function ($qq) use ($request) {
                return match ($request->string('sort')->toString()) {
                    'price_asc'  => $qq->orderBy('price', 'asc'),
                    'price_desc' => $qq->orderBy('price', 'desc'),
                    'name_asc'   => $qq->orderBy('name', 'asc'),
                    'name_desc'  => $qq->orderBy('name', 'desc'),
                    default      => $qq->latest('id'),
                };
            }, fn($qq) => $qq->latest('id'));

        // 🚀 OTTIMIZZAZIONE: Paginazione ottimizzata
        $pizzas = $q->paginate(12)->withQueryString(); // Aumentato a 12 per migliori performance

        // 🚀 OTTIMIZZAZIONE: Cache per filtri con TTL di 10 minuti
        $filters = \Illuminate\Support\Facades\Cache::remember('pizza_filters', 600, function () {
            return [
                'categories'  => Category::orderBy('name')->pluck('name','id'),
                'ingredients' => Ingredient::orderBy('name')->pluck('name','id'),
            ];
        });

        return view('admin.pizzas.index', compact('pizzas','filters'));
    }

    /**
     * Mostra form di creazione pizza.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        $allergens = Allergen::orderBy('name')->get();
        return view('admin.pizzas.create', compact('categories','ingredients','allergens'));
    }

    /**
     * Salva una nuova pizza.
     * 🚀 OTTIMIZZATO: Cache invalidation automatica
     */
    public function store(StorePizzaRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = SlugService::unique(new Pizza, $data['name']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('pizzas', 'public');
        }

        $pizza = Pizza::create($data);
        $pizza->ingredients()->sync($data['ingredients'] ?? []);

        // 🚀 OTTIMIZZAZIONE: Invalida cache dopo creazione
        $this->clearPizzaCache();

        return redirect()->route('admin.pizzas.index')->with('status', 'Pizza creata.');
    }

    /**
     * Dettaglio pizza.
     */
    public function show(Pizza $pizza): View
    {
        // Carichiamo relazioni utili per la vista di dettaglio
        $pizza->load(['category','ingredients']);
        return view('admin.pizzas.show', compact('pizza'));
    }

    /**
     * Mostra form di modifica pizza.
     */
    public function edit(Pizza $pizza): View
    {
        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        $allergens = Allergen::orderBy('name')->get();
        $pizza->load('ingredients'); // per preselezionare ingredienti nel form

        return view('admin.pizzas.edit', compact('pizza','categories','ingredients','allergens'));
    }

    /**
     * Aggiorna una pizza esistente.
     * 🚀 OTTIMIZZATO: Cache invalidation automatica
     */
    public function update(UpdatePizzaRequest $request, Pizza $pizza): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = SlugService::unique(new Pizza, $data['name'], $pizza->id);

        if ($request->hasFile('image')) {
            if ($pizza->image_path) {
                Storage::disk('public')->delete($pizza->image_path);
            }
            $data['image_path'] = $request->file('image')->store('pizzas', 'public');
        }

        $pizza->update($data);
        $pizza->ingredients()->sync($data['ingredients'] ?? []);

        // 🚀 OTTIMIZZAZIONE: Invalida cache dopo modifica
        $this->clearPizzaCache();

        return redirect()->route('admin.pizzas.index')->with('status', 'Pizza aggiornata.');
    }

    /**
     * Elimina una pizza e la sua eventuale immagine associata.
     * 🚀 OTTIMIZZATO: Cache invalidation automatica
     */
    public function destroy(Pizza $pizza): RedirectResponse
    {
        if ($pizza->image_path) {
            Storage::disk('public')->delete($pizza->image_path);
        }
        $pizza->delete();
        
        // 🚀 OTTIMIZZAZIONE: Invalida cache dopo eliminazione
        $this->clearPizzaCache();
        
        return redirect()->route('admin.pizzas.index')->with('status', 'Pizza eliminata.');
    }

    /**
     * 🚀 METODO HELPER: Invalidazione cache intelligente
     */
    private function clearPizzaCache(): void
    {
        \Illuminate\Support\Facades\Cache::forget('pizza_filters');
        \Illuminate\Support\Facades\Cache::forget('dashboard.counts');
        \Illuminate\Support\Facades\Cache::forget('dashboard.latest');
    }
}
