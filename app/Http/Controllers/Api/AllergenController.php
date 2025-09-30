<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Allergen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AllergenController extends Controller
{
    public function index()
    {
        return Allergen::latest()->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $data['slug'] = Str::slug($data['name']);
        $allergen = Allergen::create($data);
        return response()->json($allergen, 201);
    }

    public function show(Allergen $allergen)
    {
        return $allergen;
    }

    public function update(Request $request, Allergen $allergen)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $data['slug'] = Str::slug($data['name']);
        $allergen->update($data);
        return $allergen;
    }

    public function destroy(Allergen $allergen)
    {
        $allergen->delete();
        return response()->noContent();
    }
}
