<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AllergenController extends Controller
{
    public function index(): View
    {
        $allergens = Allergen::latest()->paginate(10);
        return view('allergens.index', compact('allergens'));
    }

    public function create(): View
    {
        return view('allergens.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $data['slug'] = Str::slug($data['name']);

        Allergen::create($data);
    return redirect()->route('admin.allergens.index')->with('status', 'Allergene creato.');
    }

    public function show(Allergen $allergen): View
    {
        return view('allergens.show', compact('allergen'));
    }

    public function edit(Allergen $allergen): View
    {
        return view('allergens.edit', compact('allergen'));
    }

    public function update(Request $request, Allergen $allergen): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $data['slug'] = Str::slug($data['name']);
        $allergen->update($data);
    return redirect()->route('admin.allergens.index')->with('status', 'Allergene aggiornato.');
    }

    public function destroy(Allergen $allergen): RedirectResponse
    {
        $allergen->delete();
    return redirect()->route('admin.allergens.index')->with('status', 'Allergene eliminato.');
    }
}
