@extends('layouts.app-modern')

@section('title', 'Gestione Dessert')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">
            <i class="fas fa-birthday-cake text-warning me-2"></i>
            Gestione Dessert
        </h1>
        <p class="page-subtitle">Organizza e modifica i tuoi dolci e dessert</p>
    </div>
    <div class="d-flex gap-2">
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-list me-1"></i>
            {{ $desserts->total() ?? 0 }} dessert totali
        </span>
        <a class="btn btn-warning px-4 py-2" href="{{ route('admin.desserts.create') }}">
            <i class="fas fa-plus me-2"></i>
            Nuovo Dessert
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
                searchPlaceholder="Cerca dessert per nome o descrizione..."
                :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A', 'price_asc' => 'Prezzo ↑', 'price_desc' => 'Prezzo ↓']"
                :reset-url="route('admin.desserts.index')"
            />
        </div>
    </div>

    {{-- Griglia dessert moderna --}}
    <div class="row g-4" aria-live="polite">
        @forelse($desserts as $d)
            <div class="col-12 col-lg-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm hover-lift" role="article" aria-label="Scheda dessert {{ $d->name }}">
                    @if($d->image_path)
                        <div class="position-relative">
                            <img src="{{ asset('storage/'.$d->image_path) }}" 
                                 alt="Immagine dessert {{ $d->name }}" 
                                 class="card-img-top" 
                                 style="height:200px;object-fit:cover;">
                        </div>
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                            <div class="text-center text-muted">
                                <i class="fas fa-birthday-cake fs-1 mb-2 text-warning"></i>
                                <div class="small">Nessuna immagine</div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <a href="{{ route('admin.desserts.show', $d) }}" 
                               class="h5 mb-0 text-decoration-none fw-bold text-dark hover-primary">
                                {{ $d->name }}
                            </a>
                            <div class="text-end">
                                <div class="h5 mb-0 text-warning fw-bold">
                                    €{{ number_format($d->price, 2, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        
                        @if($d->description)
                            <div class="mb-3">
                                <div class="small text-muted mb-1">
                                    <i class="fas fa-align-left me-1"></i>
                                    Descrizione:
                                </div>
                                <div class="small text-dark">
                                    {{ \Illuminate\Support\Str::limit($d->description, 120) }}
                                </div>
                            </div>
                        @endif
                        
                        @if($d->ingredients && $d->ingredients->isNotEmpty())
                            <div class="mb-3">
                                <div class="small text-muted mb-1">
                                    <i class="fas fa-seedling me-1"></i>
                                    Ingredienti:
                                </div>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($d->ingredients->take(3) as $ingredient)
                                        <span class="badge bg-light text-dark">{{ $ingredient->name }}</span>
                                    @endforeach
                                    @if($d->ingredients->count() > 3)
                                        <span class="badge bg-secondary">+{{ $d->ingredients->count() - 3 }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        @if(!empty($d->notes))
                            <div class="alert alert-info py-2 px-3 mb-3 small border-0" role="note">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>Nota:</strong> {{ \Illuminate\Support\Str::limit($d->notes, 80) }}
                            </div>
                        @endif
                        
                        <div class="d-flex gap-2 mt-auto">
                            <a class="btn btn-outline-warning btn-sm flex-fill" 
                               href="{{ route('admin.desserts.edit', $d) }}" 
                               aria-label="Modifica dessert {{ $d->name }}">
                                <i class="fas fa-edit me-1"></i>
                                Modifica
                            </a>
                            <form class="flex-fill" method="POST" action="{{ route('admin.desserts.destroy', $d) }}" 
                                  data-confirm="Sicuro di voler eliminare il dessert '{{ $d->name }}'?">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm w-100" 
                                        type="submit" 
                                        aria-label="Elimina dessert {{ $d->name }}">
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
                        <div class="display-1 text-muted mb-3">🍰</div>
                        <h4 class="text-muted mb-3">Nessun dessert trovato</h4>
                        <p class="text-muted mb-4">Inizia ad aggiungere dessert per arricchire il tuo menu</p>
                        <a href="{{ route('admin.desserts.create') }}" class="btn btn-warning">
                            <i class="fas fa-plus me-2"></i>
                            Crea il primo dessert
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Paginazione moderna --}}
    @if($desserts->hasPages())
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Navigazione dessert">
                {{ $desserts->links() }}
            </nav>
        </div>
    @endif
@endsection