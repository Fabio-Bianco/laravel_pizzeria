<?php

namespace App\Http\Controllers;

use App\Models\Beverage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

class BeverageController extends Controller
{
    public function index(): View
    {
        $beverages = Beverage::latest()->paginate(10);
        return view('admin.beverages.index', compact('beverages'));
    }

    public function create(): View
    {
        return view('admin.beverages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('beverages', 'name')],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);
        $data['slug'] = $this->generateUniqueSlug($data['name']);
        Beverage::create($data);
        return redirect()->route('admin.beverages.index')->with('status', 'Bevanda creata.');
    }

    public function show(Beverage $beverage): View
    {
        return view('admin.beverages.show', compact('beverage'));
    }

    public function edit(Beverage $beverage): View
    {
        return view('admin.beverages.edit', compact('beverage'));
    }

    public function update(Request $request, Beverage $beverage): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('beverages', 'name')->ignore($beverage->id)],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);
        $data['slug'] = $this->generateUniqueSlug($data['name'], $beverage->id);
        $beverage->update($data);
        return redirect()->route('admin.beverages.index')->with('status', 'Bevanda aggiornata.');
    }

    public function destroy(Beverage $beverage): RedirectResponse
    {
        $beverage->delete();
        return redirect()->route('admin.beverages.index')->with('status', 'Bevanda eliminata.');
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $suffixCounter = 2;
        while (
            Beverage::where('slug', $slug)
                ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$suffixCounter;
            $suffixCounter++;
        }
        return $slug;
    }
}
