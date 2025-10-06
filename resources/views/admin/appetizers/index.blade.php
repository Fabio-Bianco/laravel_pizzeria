@extends('layouts.app-modern')

@section('title', 'Gestione Antipasti')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">
            <i class="fas fa-salad text-success me-2"></i>
            Gestione Antipasti
        </h1>
        <p class="page-subtitle">Organizza e modifica i tuoi antipasti e stuzzichini</p>
    </div>
    <div class="d-flex gap-2">
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-list me-1"></i>
            {{ $appetizers->total() ?? 0 }} antipasti totali
        </span>
        <a class="btn btn-success px-4 py-2" href="{{ route('admin.appetizers.create') }}">
            <i class="fas fa-plus me-2"></i>
            Nuovo Antipasto
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
                searchPlaceholder="Cerca antipasti per nome o descrizione..."
                :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A', 'price_asc' => 'Prezzo ↑', 'price_desc' => 'Prezzo ↓']"
                :reset-url="route('admin.appetizers.index')"
            />
        </div>
    </div>

    {{-- Griglia antipasti moderna --}}
    <div class="row g-4" aria-live="polite">
        @forelse($appetizers as $a)
            <div class="col-12 col-lg-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm hover-lift" role="article" aria-label="Scheda antipasto {{ $a->name }}">
                    @if($a->image_path)
                        <div class="position-relative">
                            <img src="{{ asset('storage/'.$a->image_path) }}" 
                                 alt="Immagine antipasto {{ $a->name }}" 
                                 class="card-img-top" 
                                 style="height:200px;object-fit:cover;">
                        </div>
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                            <div class="text-center text-muted">
                                <i class="fas fa-salad fs-1 mb-2 text-success"></i>
                                <div class="small">Nessuna immagine</div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <a href="{{ route('admin.appetizers.show', $a) }}" 
                               class="h5 mb-0 text-decoration-none fw-bold text-dark hover-primary">
                                {{ $a->name }}
                            </a>
                            <div class="text-end">
                                <div class="h5 mb-0 text-success fw-bold">
                                    €{{ number_format($a->price, 2, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        
                        @if($a->description)
                            <div class="mb-3">
                                <div class="small text-muted mb-1">
                                    <i class="fas fa-align-left me-1"></i>
                                    Descrizione:
                                </div>
                                <div class="small text-dark">
                                    {{ \Illuminate\Support\Str::limit($a->description, 120) }}
                                </div>
                            </div>
                        @endif
                        
                        @if($a->ingredients && $a->ingredients->isNotEmpty())
                            <div class="mb-3">
                                <div class="small text-muted mb-1">
                                    <i class="fas fa-seedling me-1"></i>
                                    Ingredienti:
                                </div>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($a->ingredients->take(3) as $ingredient)
                                        <span class="badge bg-light text-dark">{{ $ingredient->name }}</span>
                                    @endforeach
                                    @if($a->ingredients->count() > 3)
                                        <span class="badge bg-secondary">+{{ $a->ingredients->count() - 3 }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        @if(!empty($a->notes))
                            <div class="alert alert-info py-2 px-3 mb-3 small border-0" role="note">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>Nota:</strong> {{ \Illuminate\Support\Str::limit($a->notes, 80) }}
                            </div>
                        @endif
                        
                        <div class="d-flex gap-2 mt-auto">
                            <a class="btn btn-outline-success btn-sm flex-fill" 
                               href="{{ route('admin.appetizers.edit', $a) }}" 
                               aria-label="Modifica antipasto {{ $a->name }}">
                                <i class="fas fa-edit me-1"></i>
                                Modifica
                            </a>
                            <form class="flex-fill" method="POST" action="{{ route('admin.appetizers.destroy', $a) }}" 
                                  data-confirm="Sicuro di voler eliminare l'antipasto '{{ $a->name }}'?">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm w-100" 
                                        type="submit" 
                                        aria-label="Elimina antipasto {{ $a->name }}">
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
                        <div class="display-1 text-muted mb-3">🥗</div>
                        <h4 class="text-muted mb-3">Nessun antipasto trovato</h4>
                        <p class="text-muted mb-4">Inizia ad aggiungere antipasti per arricchire il tuo menu</p>
                        <a href="{{ route('admin.appetizers.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>
                            Crea il primo antipasto
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Paginazione moderna --}}
    @if($appetizers->hasPages())
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Navigazione antipasti">
                {{ $appetizers->links('pagination.custom') }}
            </nav>
        </div>
    @endif
@endsection
