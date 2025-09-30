<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Pizza;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class PizzaController extends Controller
{
    public function index(): View
    {
        $pizzas = Pizza::with('category')->latest()->paginate(10);
        return view('pizzas.index', compact('pizzas'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        return view('pizzas.create', compact('categories', 'ingredients'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('pizzas', 'name')],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'ingredients' => ['array'],
            'ingredients.*' => ['integer', 'exists:ingredients,id'],
        ]);

        $data['slug'] = $this->generateUniqueSlug($data['name']);

        $pizza = Pizza::create($data);
        $pizza->ingredients()->sync($request->input('ingredients', []));

    return redirect()->route('admin.pizzas.index')->with('status', 'Pizza creata.');
    }

    public function show(Pizza $pizza): View
    {
        $pizza->load(['category', 'ingredients']);
        return view('pizzas.show', compact('pizza'));
    }

    public function edit(Pizza $pizza): View
    {
        $categories = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        $pizza->load('ingredients');
        return view('pizzas.edit', compact('pizza', 'categories', 'ingredients'));
    }

    public function update(Request $request, Pizza $pizza): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('pizzas', 'name')->ignore($pizza->id)],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'ingredients' => ['array'],
            'ingredients.*' => ['integer', 'exists:ingredients,id'],
        ]);

        $data['slug'] = $this->generateUniqueSlug($data['name'], $pizza->id);

        $pizza->update($data);
        $pizza->ingredients()->sync($request->input('ingredients', []));

    return redirect()->route('admin.pizzas.index')->with('status', 'Pizza aggiornata.');
    }

    public function destroy(Pizza $pizza): RedirectResponse
    {
        $pizza->delete();
    return redirect()->route('admin.pizzas.index')->with('status', 'Pizza eliminata.');
    }

    // Helpers
    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $suffixCounter = 2;
        while (
            Pizza::where('slug', $slug)
                ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$suffixCounter;
            $suffixCounter++;
        }
        return $slug;
    }
}
