@extends('layouts.app-modern')

@section('title', 'Gestione Ingredienti')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">
            <i class="fas fa-seedling text-success me-2"></i>
            Gestione Ingredienti
        </h1>
        <p class="page-subtitle">Organizza gli ingredienti per il sistema allergeni intelligente</p>
    </div>
    <div class="d-flex gap-2">
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-list me-1"></i>
            {{ $ingredients->total() ?? 0 }} ingredienti totali
        </span>
        <a class="btn btn-success px-4 py-2" href="{{ route('admin.ingredients.create') }}">
            <i class="fas fa-plus me-2"></i>
            Nuovo Ingrediente
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
                searchPlaceholder="Cerca ingredienti per nome..."
                :selects="[
                    ['name' => 'allergen', 'placeholder' => 'Filtra per allergene', 'options' => ($filters['allergens'] ?? [])],
                ]"
                :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A']"
                :reset-url="route('admin.ingredients.index')"
            />
        </div>
    </div>

    {{-- Info sistema allergeni --}}
    <div class="alert alert-info border-0 mb-4">
        <div class="d-flex align-items-start">
            <i class="fas fa-robot fs-4 me-3 mt-1"></i>
            <div>
                <h6 class="alert-heading mb-1">
                    <i class="fas fa-magic me-1"></i>
                    Sistema Allergeni Intelligente
                </h6>
                <p class="mb-0 small">
                    Gli allergeni associati agli ingredienti vengono calcolati automaticamente nelle pizze. 
                    Assicurati che ogni ingrediente abbia i suoi allergeni correttamente configurati.
                </p>
            </div>
        </div>
    </div>

    {{-- Griglia ingredienti moderna --}}
    <div class="row g-4" aria-live="polite">
        @forelse($ingredients as $ing)
            <div class="col-12 col-lg-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm hover-lift" role="article" aria-label="Scheda ingrediente {{ $ing->name }}">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="flex-grow-1">
                                <a href="{{ route('admin.ingredients.show', $ing) }}" 
                                   class="h5 mb-1 text-decoration-none fw-bold text-dark hover-primary d-block">
                                    <i class="fas fa-leaf me-2 text-success"></i>
                                    {{ $ing->name }}
                                </a>
                                
                                {{-- Badge speciali --}}
                                <div class="d-flex flex-wrap gap-1 mb-2">
                                    @if($ing->is_tomato ?? false)
                                        <span class="badge bg-danger bg-opacity-10 text-danger">
                                            <i class="fas fa-tomato me-1"></i>
                                            Pomodoro
                                        </span>
                                    @endif
                                    @if($ing->is_cheese ?? false)
                                        <span class="badge bg-warning bg-opacity-10 text-warning">
                                            <i class="fas fa-cheese me-1"></i>
                                            Formaggio
                                        </span>
                                    @endif
                                    @if($ing->is_meat ?? false)
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <i class="fas fa-drumstick-bite me-1"></i>
                                            Carne
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Contatore utilizzo --}}
                            <div class="text-end">
                                <div class="badge bg-info bg-opacity-10 text-info fs-6 px-2 py-1">
                                    <i class="fas fa-pizza-slice me-1"></i>
                                    {{ $ing->pizzas_count ?? 0 }}
                                </div>
                                <div class="small text-muted">utilizzi</div>
                            </div>
                        </div>
                        
                        {{-- Allergeni --}}
                        @php($allergenNames = $ing->allergens->pluck('name'))
                        <div class="mb-3 flex-grow-1">
                            <div class="small text-muted mb-1">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Allergeni associati:
                            </div>
                            @if($allergenNames->isNotEmpty())
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($allergenNames as $allergen)
                                        <span class="badge bg-warning bg-opacity-25 text-warning">{{ $allergen }}</span>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-success small">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Nessun allergene
                                </div>
                            @endif
                        </div>
                        
                        {{-- Utilizzo nelle pizze --}}
                        @if($ing->pizzas_count > 0)
                            <div class="alert alert-success py-2 px-3 mb-3 small border-0">
                                <i class="fas fa-chart-line me-1"></i>
                                <strong>Popolare:</strong> Usato in {{ $ing->pizzas_count }} {{ $ing->pizzas_count === 1 ? 'pizza' : 'pizze' }}
                            </div>
                        @else
                            <div class="alert alert-warning py-2 px-3 mb-3 small border-0">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>Non utilizzato:</strong> Considera di rimuoverlo o usarlo in una pizza
                            </div>
                        @endif
                        
                        {{-- Azioni --}}
                        <div class="d-flex gap-2 mt-auto">
                            <a class="btn btn-outline-success btn-sm flex-fill" 
                               href="{{ route('admin.ingredients.edit', $ing) }}" 
                               aria-label="Modifica ingrediente {{ $ing->name }}">
                                <i class="fas fa-edit me-1"></i>
                                Modifica
                            </a>
                            <form class="flex-fill" method="POST" action="{{ route('admin.ingredients.destroy', $ing) }}" 
                                  data-confirm="Sicuro di voler eliminare l'ingrediente '{{ $ing->name }}'? Verrà rimosso da tutte le pizze.">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm w-100" 
                                        type="submit" 
                                        aria-label="Elimina ingrediente {{ $ing->name }}"
                                        @if($ing->pizzas_count > 0) 
                                            title="Attenzione: usato in {{ $ing->pizzas_count }} pizze"
                                        @endif>
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
                        <div class="display-1 text-muted mb-3">🥬</div>
                        <h4 class="text-muted mb-3">Nessun ingrediente trovato</h4>
                        <p class="text-muted mb-4">Gli ingredienti sono fondamentali per il sistema allergeni automatico</p>
                        <a href="{{ route('admin.ingredients.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>
                            Crea il primo ingrediente
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Paginazione moderna --}}
    @if($ingredients->hasPages())
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Navigazione ingredienti">
                {{ $ingredients->links() }}
            </nav>
        </div>
    @endif
@endsection
