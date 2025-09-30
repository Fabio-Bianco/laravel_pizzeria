<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        Category::create($data);

    return redirect()->route('admin.categories.index')->with('status', 'Categoria creata.');
    }

    public function show(Category $category): View
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $category->update($data);

    return redirect()->route('admin.categories.index')->with('status', 'Categoria aggiornata.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
    return redirect()->route('admin.categories.index')->with('status', 'Categoria eliminata.');
    }
}
