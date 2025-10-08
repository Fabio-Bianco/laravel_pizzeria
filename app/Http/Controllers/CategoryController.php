<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        \DB::enableQueryLog();
        if ($request->query()) {
            session(['categories.index.query' => $request->query()]);
        }
        $q = Category::query()
            ->withCount('pizzas')
            ->select(['id','name','slug','description'])
            ->when($request->filled('search'), function ($qq) use ($request) {
                $term = '%'.$request->string('search')->trim().'%';
                $qq->where(function ($w) use ($term) {
                    $w->where('name', 'like', $term)
                      ->orWhere('description', 'like', $term);
                });
            })
            ->when($request->filled('sort'), function ($qq) use ($request) {
                return match ($request->string('sort')->toString()) {
                    'name_asc'  => $qq->orderBy('name', 'asc'),
                    'name_desc' => $qq->orderBy('name', 'desc'),
                    default     => $qq->latest('id'),
                };
            }, fn($qq) => $qq->latest('id'));

        $categories = $q->paginate(10)->withQueryString();

        $filters = \Cache::remember('admin.category.filters', 600, function () {
            return [
                // eventuali select future
            ];
        });

        foreach (\DB::getQueryLog() as $query) {
            if (($query['time'] ?? 0) > 100) {
                \Log::warning('Query lenta CategoryController@index', $query);
            }
        }

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_white' => ['nullable','boolean'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_white'] = $request->boolean('is_white');

        Category::create($data);

    $qs = session('categories.index.query', []);
    return redirect()->route('admin.categories.index', $qs)->with('status', 'Categoria creata.');
    }

    public function show(Category $category): View
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_white' => ['nullable','boolean'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_white'] = $request->boolean('is_white');
        $category->update($data);

    $qs = session('categories.index.query', []);
    return redirect()->route('admin.categories.index', $qs)->with('status', 'Categoria aggiornata.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
    $qs = session('categories.index.query', []);
    return redirect()->route('admin.categories.index', $qs)->with('status', 'Categoria eliminata.');
    }
}
