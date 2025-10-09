<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBeverageRequest;
use App\Http\Requests\UpdateBeverageRequest;
use App\Models\Beverage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

class BeverageController extends Controller
{
    public function index(Request $request): View
    {
        \DB::enableQueryLog();
        if ($request->query()) {
            session(['beverages.index.query' => $request->query()]);
        }
        $q = Beverage::query()
            ->select(['id','name','slug','price','description'])
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

        $beverages = $q->paginate(10)->withQueryString();

        $filters = \Cache::remember('admin.beverage.filters', 600, function () {
            return [
                // eventuali select future
            ];
        });

        foreach (\DB::getQueryLog() as $query) {
            if (($query['time'] ?? 0) > 100) {
                \Log::warning('Query lenta BeverageController@index', $query);
            }
        }

        return view('admin.beverages.index', compact('beverages'));
    }

    public function create(): View
    {
        return view('admin.beverages.create');
    }

    public function store(StoreBeverageRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->generateUniqueSlug($data['name']);
        $data['is_gluten_free'] = $request->boolean('is_gluten_free', false);
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('beverages', 'public');
        }
        Beverage::create($data);
        $qs = session('beverages.index.query', []);
        return redirect()->route('admin.beverages.index', $qs)->with('status', 'Bevanda creata.');
    }

    public function show(Beverage $beverage): View
    {
        return view('admin.beverages.show', compact('beverage'));
    }

    public function edit(Beverage $beverage): View
    {
        return view('admin.beverages.edit', compact('beverage'));
    }

    public function update(UpdateBeverageRequest $request, Beverage $beverage): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->generateUniqueSlug($data['name'], $beverage->id);
        $data['is_gluten_free'] = $request->boolean('is_gluten_free', false);
        if ($request->hasFile('image')) {
            if ($beverage->image_path) {
                \Storage::disk('public')->delete($beverage->image_path);
            }
            $data['image_path'] = $request->file('image')->store('beverages', 'public');
        }
        $beverage->update($data);
        $qs = session('beverages.index.query', []);
        return redirect()->route('admin.beverages.index', $qs)->with('status', 'Bevanda aggiornata.');
    }

    public function destroy(Beverage $beverage): RedirectResponse
    {
        if ($beverage->image_path) {
            \Storage::disk('public')->delete($beverage->image_path);
        }
        $beverage->delete();
        $qs = session('beverages.index.query', []);
        return redirect()->route('admin.beverages.index', $qs)->with('status', 'Bevanda eliminata.');
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
