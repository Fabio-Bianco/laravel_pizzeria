@extends('layouts.app-modern')

@section('title', 'Ingredienti')

@section('header')
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🥄</div>
  <h1 class="display-6 fw-bold text-dark mb-2">Ingredienti</h1>
  <p class="lead text-muted mb-4">Gestisci gli ingredienti per le tue ricette</p>

  {{-- Bottone Aggiungi centrato --}}
  <div class="d-flex justify-content-center mb-4">
    <a href="{{ route('admin.ingredients.create') }}"
       class="btn btn-create btn-lg px-4 py-3"
       role="button"
       aria-label="Aggiungi un nuovo ingrediente"
       data-bs-toggle="tooltip" 
       title="Crea un nuovo ingrediente">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuovo Ingrediente
    </a>
  </div>

  <div class="mt-3">
    @php $total = method_exists($ingredients,'total') ? $ingredients->total() : ($ingredients->count() ?? 0); @endphp
    <span class="badge badge-success fs-6 px-3 py-2">
      Hai {{ $total }} {{ $total == 1 ? 'ingrediente' : 'ingredienti' }} disponibili
    </span>
  </div>
</div>
@endsection

@section('content')
  @if(($ingredients->count() ?? 0) === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🥄</div>
          <h3 class="fw-bold text-dark mb-3">Nessun ingrediente presente</h3>
          <p class="text-muted mb-4">Crea il tuo primo ingrediente per iniziare.</p>
          <a class="btn btn-create btn-lg px-4 py-3" href="{{ route('admin.ingredients.create') }}">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea il Primo Ingrediente
          </a>
        </div>
      </div>
    </div>
  @else
    {{-- Lista ingredienti --}}
    <div class="row g-4">
      @foreach($ingredients as $ingredient)
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex flex-column">
              {{-- Nome e info principali --}}
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0 text-truncate flex-grow-1 me-2">{{ $ingredient->name }}</h5>
                @if($ingredient->allergens && $ingredient->allergens->count() > 0)
                  <span class="badge bg-warning text-dark">{{ $ingredient->allergens->count() }} allergeni</span>
                @endif
              </div>

              @if(!empty($ingredient->description))
                <p class="card-text text-muted small mb-3">{{ \Illuminate\Support\Str::limit($ingredient->description, 100) }}</p>
              @endif

              {{-- Allergeni --}}
              @if($ingredient->allergens && $ingredient->allergens->count() > 0)
                <div class="mb-3">
                  <small class="text-muted">Allergeni:</small>
                  <div class="mt-1">
                    @foreach($ingredient->allergens->take(3) as $allergen)
                      <span class="badge bg-danger text-white me-1 mb-1">{{ $allergen->name }}</span>
                    @endforeach
                    @if($ingredient->allergens->count() > 3)
                      <span class="badge bg-secondary">+{{ $ingredient->allergens->count() - 3 }}</span>
                    @endif
                  </div>
                </div>
              @endif

              {{-- Azioni sempre in fondo --}}
              <div class="mt-auto">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('admin.ingredients.show', $ingredient) }}" 
                     class="btn btn-outline-primary btn-sm" 
                     title="Visualizza dettagli">
                    <i class="fas fa-eye" aria-hidden="true"></i>
                  </a>
                  <a href="{{ route('admin.ingredients.edit', $ingredient) }}" 
                     class="btn btn-outline-secondary btn-sm" 
                     title="Modifica ingrediente">
                    <i class="fas fa-edit" aria-hidden="true"></i>
                  </a>
                  <form method="POST" action="{{ route('admin.ingredients.destroy', $ingredient) }}" 
                        class="d-inline"
                        data-item-name="{{ $ingredient->name }}">
                    @csrf @method('DELETE')
                    <button type="submit" 
                            class="btn btn-outline-danger btn-sm" 
                            title="Elimina ingrediente">
                      <i class="fas fa-trash" aria-hidden="true"></i>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    @if(method_exists($ingredients,'hasPages') && $ingredients->hasPages())
      <div class="d-flex justify-content-center mt-5">
        {{ $ingredients->links() }}
      </div>
    @endif
  @endif
@endsection