@extends('layouts.app-modern')

@section('title', 'Le Tue Pizze')

@section('header')
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🍕</div>
  <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Pizze</h1>
  <p class="lead text-muted mb-4">Gestisci le pizze del tuo menu</p>

  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
    <a href="{{ route('admin.pizzas.create') }}"
       class="btn btn-create btn-lg px-4 py-3"
       title="Aggiungi nuova pizza" data-bs-toggle="tooltip">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuova Pizza
    </a>
    
    {{-- Toggle Layout View --}}
    <div class="view-toggle-controls" role="group" aria-label="Seleziona vista visualizzazione">
      <div class="btn-group" role="radiogroup" aria-label="Modalità visualizzazione pizze">
        <input type="radio" class="btn-check" name="viewMode" id="listView" value="list" checked>
        <label class="btn btn-outline-secondary" for="listView" 
               title="Visualizzazione a elenco" 
               aria-label="Cambia a visualizzazione a elenco">
          <i class="fas fa-list me-1" aria-hidden="true"></i>
          <span class="d-none d-sm-inline">Elenco</span>
        </label>

        <input type="radio" class="btn-check" name="viewMode" id="cardView" value="card">
        <label class="btn btn-outline-secondary" for="cardView" 
               title="Visualizzazione a griglia" 
               aria-label="Cambia a visualizzazione a griglia">
          <i class="fas fa-th-large me-1" aria-hidden="true"></i>
          <span class="d-none d-sm-inline">Griglia</span>
        </label>
      </div>
    </div>
  </div>

  <div class="mt-3">
    @php $total = method_exists($pizzas,'total') ? $pizzas->total() : ($pizzas->count() ?? 0); @endphp
    <span class="badge badge-success fs-6 px-3 py-2">
      Hai {{ $total }} {{ $total == 1 ? 'pizza' : 'pizze' }} nel menu
    </span>
  </div>
</div>
@endsection

@section('content')
  @if(($pizzas->count() ?? 0) === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🍕</div>
          <h3 class="fw-bold text-dark mb-3">Nessuna pizza presente</h3>
          <p class="text-muted mb-4">Crea la tua prima pizza per iniziare.</p>
          <a class="btn btn-create btn-lg px-4 py-3" href="{{ route('admin.pizzas.create') }}">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea la Prima Pizza
          </a>
        </div>
      </div>
    </div>
  @else
    {{-- Container che cambia layout in base al toggle --}}
    <div id="pizzas-container" class="transition-container">
      
      {{-- Vista a Elenco (default) --}}
      <div id="list-view" class="view-mode active" role="region" aria-label="Vista a elenco delle pizze">
        <div class="list-container">
          @foreach($pizzas as $p)
            <div class="list-item-pizza border-bottom py-3">
              <div class="row align-items-center">
                <div class="col-md-2 col-3">
                  @if(!empty($p->image_path))
                    <img src="{{ asset('storage/'.$p->image_path) }}" 
                         alt="Pizza {{ $p->name }}" 
                         class="img-fluid rounded" style="height:60px;width:60px;object-fit:cover;">
                  @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:60px;width:60px;">
                      <i class="fas fa-pizza-slice text-muted"></i>
                    </div>
                  @endif
                </div>
                <div class="col-md-5 col-6">
                  <h6 class="mb-1 fw-bold">
                    <a href="{{ route('admin.pizzas.show', $p) }}" class="text-decoration-none text-dark">
                      {{ $p->name }}
                    </a>
                  </h6>
                  <small class="text-muted d-block">{{ $p->notes ?? 'Nessuna descrizione' }}</small>
                  
                  {{-- Ingredienti in vista compatta --}}
                  @if(!empty($p->ingredients) && $p->ingredients->isNotEmpty())
                    <div class="mt-1">
                      <small class="text-muted">
                        <i class="fas fa-seedling me-1" aria-hidden="true"></i>
                        {{ $p->ingredients->take(3)->pluck('name')->join(', ') }}
                        @if($p->ingredients->count() > 3)
                          <span class="badge bg-info text-white ms-1" style="font-size: 10px;">
                            +{{ $p->ingredients->count() - 3 }}
                          </span>
                        @endif
                      </small>
                    </div>
                  @endif
                  
                  {{-- Allergeni compatti --}}
                  <div class="mt-1">
                    <x-allergen-display :allergens="$p" mode="minimal" :maxVisible="3" />
                  </div>
                </div>
                <div class="col-md-2 col-3 text-center">
                  <span class="h6 text-success fw-bold">€{{ number_format($p->price ?? 0, 2, ',', '.') }}</span>
                  @if(!empty($p->is_vegan))
                    <br><small class="badge bg-success text-white">🌱 Vegana</small>
                  @endif
                </div>
                <div class="col-md-3 col-12 mt-2 mt-md-0">
                  <div class="btn-group btn-group-sm w-100">
                    <a href="{{ route('admin.pizzas.show', $p) }}" class="btn btn-view btn-sm flex-fill">
                      <i class="fas fa-eye me-1" aria-hidden="true"></i>
                      <span class="d-none d-sm-inline">Dettagli</span>
                    </a>
                    <a href="{{ route('admin.pizzas.edit', $p) }}" class="btn btn-edit btn-sm flex-fill">
                      <i class="fas fa-edit me-1" aria-hidden="true"></i>
                      <span class="d-none d-sm-inline">Modifica</span>
                    </a>
                    <form method="POST" action="{{ route('admin.pizzas.destroy', $p) }}" class="flex-fill d-inline"
                          onsubmit="return confirm('Eliminare definitivamente {{ $p->name }}?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-delete btn-sm w-100" data-bs-toggle="tooltip" title="Elimina">
                        <i class="fas fa-trash me-1" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline">Elimina</span>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      
      {{-- Vista a Griglia --}}
      <div id="card-view" class="view-mode" role="region" aria-label="Vista a griglia delle pizze" style="display: none;">
        <div class="row g-4">
          @foreach($pizzas as $p)
            <div class="col-lg-4 col-md-6">
              <div class="card h-100 border-0 shadow-sm">
                @if(!empty($p->image_path))
                  <div class="position-relative">
                    <img src="{{ asset('storage/'.$p->image_path) }}"
                         alt="Immagine pizza {{ $p->name }}"
                         class="card-img-top" style="height:200px;object-fit:cover;">
                    @if(!empty($p->is_vegan))
                      <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">
                        <i class="fas fa-leaf me-1"></i> Vegana
                      </span>
                    @endif
                    @if(!empty($p->is_special))
                      <span class="position-absolute top-0 end-0 badge bg-warning text-dark m-2">
                        ⭐ Special
                      </span>
                    @endif
                  </div>
                @else
                  <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                    <div class="text-center text-muted">
                      <i class="fas fa-pizza-slice fs-1 mb-2"></i>
                      <div class="small">Nessuna immagine</div>
                    </div>
                  </div>
                @endif

                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <a href="{{ route('admin.pizzas.show', $p) }}"
                       class="h5 mb-0 text-decoration-none fw-bold text-dark">
                      {{ $p->name }}
                    </a>
                    <div class="h5 mb-0 text-success fw-bold">
                      €{{ number_format($p->price ?? 0, 2, ',', '.') }}
                    </div>
                  </div>

                  @if(!empty($p->description))
                    <p class="card-text text-muted mb-3" style="line-height:1.5;">
                      {{ \Illuminate\Support\Str::limit($p->description, 120) }}
                    </p>
                  @endif

                  @if(!empty($p->ingredients) && $p->ingredients->isNotEmpty())
                    <div class="mb-3">
                      <div class="small text-muted mb-1">
                        <i class="fas fa-seedling me-1" aria-hidden="true"></i> Ingredienti:
                      </div>
                      <div class="d-flex flex-wrap gap-1">
                        @foreach($p->ingredients->take(4) as $ingredient)
                          <span class="badge bg-light text-dark">{{ $ingredient->name }}</span>
                        @endforeach
                        @if($p->ingredients->count() > 4)
                          <span class="badge bg-info text-white" 
                                role="button"
                                tabindex="0"
                                title="Altri {{ $p->ingredients->count() - 4 }} ingredienti non mostrati"
                                aria-label="Mostra altri {{ $p->ingredients->count() - 4 }} ingredienti di {{ $p->name }}">
                            <i class="fas fa-plus me-1" aria-hidden="true"></i>{{ $p->ingredients->count() - 4 }}
                          </span>
                        @endif
                      </div>
                    </div>
                  @endif

                  {{-- Sistema allergeni semantico --}}
                  <div class="mb-3">
                    <x-allergen-display :allergens="$p" mode="compact" :maxVisible="3" />
                  </div>

                  <div class="d-flex gap-2 mt-auto">
                    <a class="btn btn-view btn-sm flex-fill"
                       href="{{ route('admin.pizzas.show', $p) }}"
                       data-bs-toggle="tooltip" title="Dettagli">
                      <i class="fas fa-eye me-1" aria-hidden="true"></i> Dettagli
                    </a>
                    <a class="btn btn-edit btn-sm flex-fill"
                       href="{{ route('admin.pizzas.edit', $p) }}"
                       data-bs-toggle="tooltip" title="Modifica">
                      <i class="fas fa-edit me-1" aria-hidden="true"></i> Modifica
                    </a>
                    <form method="POST" action="{{ route('admin.pizzas.destroy', $p) }}" class="flex-fill"
                          onsubmit="return confirm('Eliminare definitivamente {{ $p->name }}?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-delete btn-sm w-100" data-bs-toggle="tooltip" title="Elimina">
                        <i class="fas fa-trash me-1" aria-hidden="true"></i> Elimina
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      
    </div>

    @if(method_exists($pizzas,'hasPages') && $pizzas->hasPages())
      <div class="d-flex justify-content-center mt-5">
        {{ $pizzas->links() }}
      </div>
    @endif
  @endif
@endsection
