<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePizzaRequest;
use App\Http\Requests\UpdatePizzaRequest;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Pizza;
use App\Support\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class PizzaController extends Controller
{
    public function index(Request $request): View
    {
        $q = Pizza::query()
            ->with(['category', 'ingredients.allergens'])
            ->withCount('ingredients')
            // Full-text like search on name and notes (description dropped from schema)
            ->when($request->filled('search'), function ($qq) use ($request) {
                $term = '%'.$request->string('search')->trim().'%';
                $qq->where(function ($w) use ($term) {
                    $w->where('name', 'like', $term)
                      ->orWhere('notes', 'like', $term);
                });
            })
            ->when($request->filled('category'), fn($qq) =>
                $qq->where('category_id', $request->integer('category')))
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

        $pizzas = $q->paginate(10)->withQueryString();

        $filters = [
            'categories'  => Category::orderBy('name')->pluck('name','id'),
            'ingredients' => Ingredient::orderBy('name')->pluck('name','id'),
        ];

        return view('admin.pizzas.index', compact('pizzas','filters'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        return view('admin.pizzas.create', compact('categories','ingredients'));
    }

    public function store(StorePizzaRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = SlugService::unique(new Pizza, $data['name']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('pizzas', 'public');
        }

        $pizza = Pizza::create($data);
        $pizza->ingredients()->sync($data['ingredients'] ?? []);

        return redirect()->route('admin.pizzas.index')->with('status', 'Pizza creata.');
    }

    public function show(Pizza $pizza): View
    {
        $pizza->load(['category','ingredients']);
        return view('admin.pizzas.show', compact('pizza'));
    }

    public function edit(Pizza $pizza): View
    {
        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        $pizza->load('ingredients');

        return view('admin.pizzas.edit', compact('pizza','categories','ingredients'));
    }

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

        return redirect()->route('admin.pizzas.index')->with('status', 'Pizza aggiornata.');
    }

    public function destroy(Pizza $pizza): RedirectResponse
    {
        if ($pizza->image_path) {
            Storage::disk('public')->delete($pizza->image_path);
        }
        $pizza->delete();
        return redirect()->route('admin.pizzas.index')->with('status', 'Pizza eliminata.');
    }
}
