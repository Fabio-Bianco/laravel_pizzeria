<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppetizerResource;
use App\Models\Appetizer;
use Illuminate\Http\Request;

class AppetizerController extends Controller
{
    /**
     * Lista antipasti (guest) con paginazione e filtri base.
     */
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 50);

        $query = Appetizer::query()
            ->with(['ingredients.allergens'])
            ->select(['id','name','slug','price','description'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = '%'.$request->string('search')->trim().'%';
                $q->where('name', 'like', $term);
            })
            ->when($request->filled('sort'), function ($q) use ($request) {
                return match ($request->string('sort')->toString()) {
                    'name_desc' => $q->orderBy('name', 'desc'),
                    default     => $q->orderBy('name', 'asc'),
                };
            }, fn($q) => $q->orderBy('name', 'asc'));

        $paginator = $query->paginate($perPage)->appends($request->query());

        return response()->json([
            'data'  => AppetizerResource::collection($paginator->getCollection()),
            'meta'  => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ],
            'links' => [
                'first' => $paginator->url(1),
                'last'  => $paginator->url($paginator->lastPage()),
                'prev'  => $paginator->previousPageUrl(),
                'next'  => $paginator->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Dettaglio antipasto.
     */
    public function show(Appetizer $appetizer)
    {
        $appetizer->load(['ingredients.allergens']);
        return AppetizerResource::make($appetizer)->response();
    }
}
