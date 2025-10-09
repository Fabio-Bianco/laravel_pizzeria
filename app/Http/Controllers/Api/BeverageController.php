<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BeverageResource;
use App\Models\Beverage;
use Illuminate\Http\Request;

class BeverageController extends Controller
{
    /**
     * Lista bevande (guest) con paginazione e filtri base.
     */
    public function index(Request $request)
    {
            $perPage = min(max((int) $request->query('per_page', 10), 1), 50);
            $cacheKey = 'api.beverages.' . md5(json_encode($request->query()));
            $result = \Cache::remember($cacheKey, 30, function () use ($request, $perPage) {
                $query = Beverage::query()
                    ->select(['id','name','slug','price','description','formato','tipologia','gradazione_alcolica','is_gluten_free'])
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
                    'data'  => BeverageResource::collection($paginator->getCollection()),
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
            // Nessun blocco try/catch qui: lasciamo propagare l'errore a livello globale (gestione Laravel)
    }

    /**
     * Dettaglio bevanda.
     */
    public function show(Beverage $beverage)
    {
        return BeverageResource::make($beverage)->response();
    }
}
