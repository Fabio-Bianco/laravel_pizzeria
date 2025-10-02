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
     *
     * Filtri supportati via query string:
     * - search: testo su name/notes
     * - category: id categoria esatta
     * - ingredient: id ingrediente contenuto nella pizza
     * - sort: price_asc|price_desc|name_asc|name_desc (default: recenti)
     */
    public function index(Request $request): View
    {
        // Costruiamo la query base con eager loading e conteggio ingredienti
        $q = Pizza::query()
            ->with(['category', 'ingredients.allergens'])
            ->withCount('ingredients')
            // Ricerca LIKE su name e notes (la colonna description è stata rimossa dallo schema)
            ->when($request->filled('search'), function ($qq) use ($request) {
                $term = '%'.$request->string('search')->trim().'%';
                // Raggruppa le condizioni in una where annidata
                $qq->where(function ($w) use ($term) {
                    $w->where('name', 'like', $term)
                      ->orWhere('notes', 'like', $term);
                });
            })
            // Filtro per categoria esatta
            ->when($request->filled('category'), fn($qq) =>
                $qq->where('category_id', $request->integer('category')))
            // Filtro per ingrediente contenuto (exists sulla relazione)
            ->when($request->filled('ingredient'), fn($qq) =>
                $qq->whereHas('ingredients', fn($w) => $w->where('ingredients.id', $request->integer('ingredient'))))
            ->when($request->filled('sort'), function ($qq) use ($request) {
                // Applica ordinamenti noti; default ai più recenti
                return match ($request->string('sort')->toString()) {
                    'price_asc'  => $qq->orderBy('price', 'asc'),
                    'price_desc' => $qq->orderBy('price', 'desc'),
                    'name_asc'   => $qq->orderBy('name', 'asc'),
                    'name_desc'  => $qq->orderBy('name', 'desc'),
                    default      => $qq->latest('id'),
                };
            }, fn($qq) => $qq->latest('id'));

        // Paginazione con mantenimento query string (per persistenza filtri sullo stesso elenco)
        $pizzas = $q->paginate(10)->withQueryString();

        // Dati per i select dei filtri
        $filters = [
            'categories'  => Category::orderBy('name')->pluck('name','id'),
            'ingredients' => Ingredient::orderBy('name')->pluck('name','id'),
        ];

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
     * - Valida i dati via StorePizzaRequest
     * - Genera slug univoco
     * - Gestisce eventuale upload immagine
     * - Sincronizza ingredienti selezionati sulla pivot
     */
    public function store(StorePizzaRequest $request): RedirectResponse
    {
        $data = $request->validated(); // dati già sanificati/validati
        $data['slug'] = SlugService::unique(new Pizza, $data['name']); // slug unico

        if ($request->hasFile('image')) {
            // Salva l'immagine nello storage pubblico e memorizza il path
            $data['image_path'] = $request->file('image')->store('pizzas', 'public');
        }

        $pizza = Pizza::create($data);
        // Allinea la relazione many-to-many (aggiunge nuove e rimuove quelle non più presenti)
        $pizza->ingredients()->sync($data['ingredients'] ?? []);

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
     * - Valida i dati via UpdatePizzaRequest (include regole incrociate: es. bianca ≠ pomodoro)
     * - Aggiorna slug univoco tenendo conto dell'ID corrente
     * - Sostituisce l'immagine se inviata, cancellando la precedente
     * - Sincronizza gli ingredienti sulla pivot
     */
    public function update(UpdatePizzaRequest $request, Pizza $pizza): RedirectResponse
    {
        $data = $request->validated(); // dati già sanificati/validati
        
        // DEBUG: ispeziona i dati validati (da rimuovere in produzione)
        // dd($data);

        // Rigenera slug assicurando l'unicità, escludendo l'ID corrente
        $data['slug'] = SlugService::unique(new Pizza, $data['name'], $pizza->id);

        if ($request->hasFile('image')) {
            if ($pizza->image_path) {
                // Rimuove il vecchio file per non lasciare orfani
                Storage::disk('public')->delete($pizza->image_path);
            }
            // Salva il nuovo file e aggiorna il path
            $data['image_path'] = $request->file('image')->store('pizzas', 'public');
        }

        $pizza->update($data); // persiste i cambi dati semplici
        $pizza->ingredients()->sync($data['ingredients'] ?? []); // allinea la pivot ingredienti

        

        return redirect()->route('admin.pizzas.index')->with('status', 'Pizza aggiornata.');
    }

    /**
     * Elimina una pizza e la sua eventuale immagine associata.
     */
    public function destroy(Pizza $pizza): RedirectResponse
    {
        if ($pizza->image_path) {
            // Pulizia del file immagine associato
            Storage::disk('public')->delete($pizza->image_path);
        }
        $pizza->delete(); // elimina record
        return redirect()->route('admin.pizzas.index')->with('status', 'Pizza eliminata.');
    }
}
