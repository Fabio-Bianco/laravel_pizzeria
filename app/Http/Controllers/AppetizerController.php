<?php

namespace App\Http\Controllers;

use App\Models\Appetizer;
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
            ->when($request->filled('search'), function ($qq) use ($request) {
                $term = '%'.$request->string('search')->trim().'%';
                $qq->where(function ($w) use ($term) {
                    $w->where('name', 'like', $term)
                      ->orWhere('description', 'like', $term);
                });
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
        return view('admin.appetizers.index', compact('appetizers'));
    }

    public function create(): View
    {
        return view('admin.appetizers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('appetizers', 'name')],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);
        $data['slug'] = $this->generateUniqueSlug($data['name']);
        Appetizer::create($data);
        return redirect()->route('admin.appetizers.index')->with('status', 'Antipasto creato.');
    }

    public function show(Appetizer $appetizer): View
    {
        return view('admin.appetizers.show', compact('appetizer'));
    }

    public function edit(Appetizer $appetizer): View
    {
        return view('admin.appetizers.edit', compact('appetizer'));
    }

    public function update(Request $request, Appetizer $appetizer): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('appetizers', 'name')->ignore($appetizer->id)],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);
        $data['slug'] = $this->generateUniqueSlug($data['name'], $appetizer->id);
        $appetizer->update($data);
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
