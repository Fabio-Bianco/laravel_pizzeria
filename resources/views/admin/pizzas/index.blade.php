@extends('layouts.app-modern')

@section('title', 'Gestione Pizze')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">
            <i class="fas fa-pizza-slice text-primary me-2"></i>
            Gestione Pizze
        </h1>
        <p class="page-subtitle">Organizza e modifica il tuo menu delle pizze</p>
    </div>
    <div class="d-flex gap-2">
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-list me-1"></i>
            {{ $pizzas->total() ?? 0 }} pizze totali
        </span>
        <a class="btn btn-primary px-4 py-2" href="{{ route('admin.pizzas.create') }}">
            <i class="fas fa-plus me-2"></i>
            Nuova Pizza
        </a>
    </div>
</div>
@endsection

@section('content')

    {{-- Barra filtri moderna --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <x-filter-toolbar
                search
                searchPlaceholder="Cerca pizze per nome o ingredienti..."
                :selects="[
                    ['name' => 'category', 'placeholder' => 'Tutte le categorie', 'options' => ($filters['categories'] ?? [])],
                    ['name' => 'ingredient', 'placeholder' => 'Qualsiasi ingrediente', 'options' => ($filters['ingredients'] ?? [])],
                ]"
                :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A', 'price_asc' => 'Prezzo ↑', 'price_desc' => 'Prezzo ↓']"
                :reset-url="route('admin.pizzas.index')"
            />
        </div>
    </div>

    {{-- Griglia pizze moderna --}}
    <div class="row g-4" aria-live="polite">
        @forelse($pizzas as $p)
            <div class="col-12 col-lg-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm hover-lift" role="article" aria-label="Scheda pizza {{ $p->name }}">
                    @if($p->image_path)
                        <div class="position-relative">
                            {{-- 🚀 LAZY LOADING OTTIMIZZATO --}}
                            <img 
                                data-src="{{ Storage::url($p->image_path) }}" 
                                alt="Immagine di {{ $p->name }}" 
                                class="card-img-top object-fit-cover"
                                style="height: 200px; opacity: 0; transition: opacity 0.3s ease;"
                                loading="lazy"
                                data-critical="{{ $loop->index < 3 ? 'true' : 'false' }}"
                            />
                            @if($p->is_bianca)
                                <span class="position-absolute top-0 end-0 badge bg-white text-dark m-2">
                                    <i class="fas fa-cheese me-1"></i>Bianca
                                </span>
                            @endif
                        </div>
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                            <div class="text-center text-muted">
                                <i class="fas fa-image fa-3x mb-2 opacity-50"></i>
                                <br><small>Nessuna immagine</small>
                            </div>
                        </div>
                    @endif                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <a href="{{ route('admin.pizzas.show', $p) }}" 
                               class="h5 mb-0 text-decoration-none fw-bold text-dark hover-primary">
                                {{ $p->name }}
                            </a>
                            <div class="text-end">
                                <div class="h5 mb-0 text-primary fw-bold">
                                    €{{ number_format($p->price, 2, ',', '.') }}
                                </div>
                                @if($p->category)
                                    <span class="badge bg-light text-muted small">{{ $p->category->name }}</span>
                                @endif
                            </div>
                        </div>
                        
                        @php($ingredientNames = $p->ingredients->pluck('name'))
                        @if($ingredientNames->isNotEmpty())
                            <div class="mb-3">
                                <div class="small text-muted mb-1">
                                    <i class="fas fa-seedling me-1"></i>
                                    Ingredienti:
                                </div>
                                <div class="small text-dark" title="{{ $ingredientNames->join(', ') }}">
                                    {{ \Illuminate\Support\Str::limit($ingredientNames->join(', '), 100) }}
                                </div>
                            </div>
                        @endif
                        
                        @php(
                            $allergenNames = collect($p->ingredients)
                                ->flatMap(fn($ing) => $ing->allergens->pluck('name'))
                                ->unique()
                                ->values()
                        )
                        @if($allergenNames->isNotEmpty())
                            <div class="mb-3">
                                <div class="small text-warning mb-1">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Allergeni:
                                </div>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($allergenNames->take(3) as $allergen)
                                        <span class="badge bg-warning bg-opacity-10 text-warning">{{ $allergen }}</span>
                                    @endforeach
                                    @if($allergenNames->count() > 3)
                                        <span class="badge bg-light text-muted">+{{ $allergenNames->count() - 3 }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        @if(!empty($p->notes))
                            <div class="alert alert-warning py-2 px-3 mb-3 small border-0" role="note">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>Nota:</strong> {{ \Illuminate\Support\Str::limit($p->notes, 80) }}
                            </div>
                        @endif
                        
                        <div class="d-flex gap-2 mt-auto">
                            <a class="btn btn-outline-primary btn-sm flex-fill" 
                               href="{{ route('admin.pizzas.edit', $p) }}" 
                               aria-label="Modifica pizza {{ $p->name }}">
                                <i class="fas fa-edit me-1"></i>
                                Modifica
                            </a>
                            <form class="flex-fill" method="POST" action="{{ route('admin.pizzas.destroy', $p) }}" 
                                  data-confirm="Sicuro di voler eliminare la pizza '{{ $p->name }}'?">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm w-100" 
                                        type="submit" 
                                        aria-label="Elimina pizza {{ $p->name }}">
                                    <i class="fas fa-trash me-1"></i>
                                    Elimina
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center py-5">
                        <div class="display-1 text-muted mb-3">🍕</div>
                        <h4 class="text-muted mb-3">Nessuna pizza trovata</h4>
                        <p class="text-muted mb-4">Inizia ad aggiungere le tue pizze per costruire il menu perfetto</p>
                        <a href="{{ route('admin.pizzas.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Crea la prima pizza
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Paginazione moderna --}}
    @if($pizzas->hasPages())
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Navigazione pizze">
                {{ $pizzas->links('pagination.custom') }}
            </nav>
        </div>
    @endif
@endsection
