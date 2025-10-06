@extends('layouts.app-modern')

@section('title', 'Gestione Bevande')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">
            <i class="fas fa-glass-water text-info me-2"></i>
            Gestione Bevande
        </h1>
        <p class="page-subtitle">Organizza e modifica la tua carta delle bevande</p>
    </div>
    <div class="d-flex gap-2">
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-list me-1"></i>
            {{ $beverages->total() ?? 0 }} bevande totali
        </span>
        <a class="btn btn-info px-4 py-2" href="{{ route('admin.beverages.create') }}">
            <i class="fas fa-plus me-2"></i>
            Nuova Bevanda
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
                searchPlaceholder="Cerca bevande per nome o descrizione..."
                :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A', 'price_asc' => 'Prezzo ↑', 'price_desc' => 'Prezzo ↓']"
                :reset-url="route('admin.beverages.index')"
            />
        </div>
    </div>

    {{-- Griglia bevande moderna --}}
    <div class="row g-4" aria-live="polite">
        @forelse($beverages as $b)
            <div class="col-12 col-lg-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm hover-lift" role="article" aria-label="Scheda bevanda {{ $b->name }}">
                    @if($b->image_path)
                        <div class="position-relative">
                            <img src="{{ asset('storage/'.$b->image_path) }}" 
                                 alt="Immagine bevanda {{ $b->name }}" 
                                 class="card-img-top" 
                                 style="height:200px;object-fit:cover;">
                        </div>
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                            <div class="text-center text-muted">
                                <i class="fas fa-glass-water fs-1 mb-2 text-info"></i>
                                <div class="small">Nessuna immagine</div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <a href="{{ route('admin.beverages.show', $b) }}" 
                               class="h5 mb-0 text-decoration-none fw-bold text-dark hover-primary">
                                {{ $b->name }}
                            </a>
                            <div class="text-end">
                                <div class="h5 mb-0 text-info fw-bold">
                                    €{{ number_format($b->price, 2, ',', '.') }}
                                </div>
                                @if(isset($b->category))
                                    <span class="badge bg-light text-muted small">{{ $b->category }}</span>
                                @endif
                            </div>
                        </div>
                        
                        @if($b->description)
                            <div class="mb-3">
                                <div class="small text-muted mb-1">
                                    <i class="fas fa-align-left me-1"></i>
                                    Descrizione:
                                </div>
                                <div class="small text-dark">
                                    {{ \Illuminate\Support\Str::limit($b->description, 120) }}
                                </div>
                            </div>
                        @endif
                        
                        @if(isset($b->alcohol_content) && $b->alcohol_content > 0)
                            <div class="mb-3">
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-wine-bottle me-1"></i>
                                    {{ $b->alcohol_content }}% Alc.
                                </span>
                            </div>
                        @elseif(isset($b->is_alcoholic) && !$b->is_alcoholic)
                            <div class="mb-3">
                                <span class="badge bg-success">
                                    <i class="fas fa-leaf me-1"></i>
                                    Analcolica
                                </span>
                            </div>
                        @endif
                        
                        @if(!empty($b->notes))
                            <div class="alert alert-info py-2 px-3 mb-3 small border-0" role="note">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>Nota:</strong> {{ \Illuminate\Support\Str::limit($b->notes, 80) }}
                            </div>
                        @endif
                        
                        <div class="d-flex gap-2 mt-auto">
                            <a class="btn btn-outline-info btn-sm flex-fill" 
                               href="{{ route('admin.beverages.edit', $b) }}" 
                               aria-label="Modifica bevanda {{ $b->name }}">
                                <i class="fas fa-edit me-1"></i>
                                Modifica
                            </a>
                            <form class="flex-fill" method="POST" action="{{ route('admin.beverages.destroy', $b) }}" 
                                  data-confirm="Sicuro di voler eliminare la bevanda '{{ $b->name }}'?">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm w-100" 
                                        type="submit" 
                                        aria-label="Elimina bevanda {{ $b->name }}">
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
                        <div class="display-1 text-muted mb-3">🥤</div>
                        <h4 class="text-muted mb-3">Nessuna bevanda trovata</h4>
                        <p class="text-muted mb-4">Inizia ad aggiungere bevande per completare la tua carta</p>
                        <a href="{{ route('admin.beverages.create') }}" class="btn btn-info">
                            <i class="fas fa-plus me-2"></i>
                            Crea la prima bevanda
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Paginazione moderna --}}
    @if($beverages->hasPages())
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Navigazione bevande">
                {{ $beverages->links('pagination.custom') }}
            </nav>
        </div>
    @endif
@endsection
