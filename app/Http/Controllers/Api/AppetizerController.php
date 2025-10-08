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
        try {
            $perPage = min(max((int) $request->query('per_page', 10), 1), 50);
            $with = ['ingredients'];
            if ($request->filled('with') && in_array('allergens', (array) $request->input('with'))) {
                $with[] = 'ingredients.allergens';
            }
            $cacheKey = 'api.appetizers.' . md5(json_encode($request->query()));
            $result = \Cache::remember($cacheKey, 30, function () use ($request, $perPage, $with) {
                $query = Appetizer::query()
                    ->with($with)
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

                return [
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
                ];
            });
            return response()->json($result);
        } catch (\Throwable $e) {
            \Log::error('API AppetizerController@index', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 'Errore interno server. Riprova più tardi.',
                'error' => app()->environment('production') ? null : $e->getMessage(),
            ], 500);
        }
        try {
            $perPage = min(max((int) $request->query('per_page', 10), 1), 50);
            $with = ['ingredients'];
            if ($request->filled('with') && in_array('allergens', (array) $request->input('with'))) {
                $with[] = 'ingredients.allergens';
            }
            $cacheKey = 'api.appetizers.' . md5(json_encode($request->query()));
            $result = \Cache::remember($cacheKey, 30, function () use ($request, $perPage, $with) {
                $query = Appetizer::query()
                    ->with($with)
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

                return [
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
                ];
            });
            return response()->json($result);
        } catch (\Throwable $e) {
            \Log::error('API AppetizerController@index', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 'Errore interno server. Riprova più tardi.',
                'error' => app()->environment('production') ? null : $e->getMessage(),
            ], 500);
        }
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
