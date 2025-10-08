@extends('layouts.app-modern')

@section('title', 'I Tuoi Dessert')

@section('header')
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🍰</div>
  <h1 class="display-6 fw-bold text-dark mb-2">I Tuoi Dolci</h1>
  <p class="lead text-muted mb-4">Tiramisù, gelati e delizie dolci</p>

  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
    <a href="{{ route('admin.desserts.create') }}"
       class="btn btn-create btn-lg px-4 py-3"
       title="Aggiungi dolce" data-bs-toggle="tooltip">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuovo Dolce
    </a>
    
    {{-- Toggle Layout View --}}
    <div class="view-toggle-controls" role="group" aria-label="Seleziona vista visualizzazione">
      <div class="btn-group" role="radiogroup" aria-label="Modalità visualizzazione dolci">
        <input type="radio" class="btn-check" name="dessertsViewMode" id="dessertsListView" value="list" checked>
        <label class="btn btn-outline-secondary" for="dessertsListView" 
               title="Visualizzazione a elenco" 
               aria-label="Cambia a visualizzazione a elenco">
          <i class="fas fa-list me-1" aria-hidden="true"></i>
          <span class="d-none d-sm-inline">Elenco</span>
        </label>

        <input type="radio" class="btn-check" name="dessertsViewMode" id="dessertsCardView" value="card">
        <label class="btn btn-outline-secondary" for="dessertsCardView" 
               title="Visualizzazione a griglia" 
               aria-label="Cambia a visualizzazione a griglia">
          <i class="fas fa-th-large me-1" aria-hidden="true"></i>
          <span class="d-none d-sm-inline">Griglia</span>
        </label>
      </div>
    </div>
  </div>

  <div class="mt-3">
    @php $total = method_exists($desserts,'total') ? $desserts->total() : ($desserts->count() ?? 0); @endphp
    <span class="badge badge-success fs-6 px-3 py-2">
      Hai {{ $total }} {{ $total == 1 ? 'dolce' : 'dolci' }} nel menu
    </span>
  </div>
</div>
@endsection

@section('content')
  @if(($desserts->count() ?? 0) === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🍰</div>
          <h3 class="fw-bold text-dark mb-3">Nessun dessert presente</h3>
          <p class="text-muted mb-4">Aggiungi il primo dolce al tuo menu.</p>
          <a class="btn btn-create btn-lg px-4 py-3" href="{{ route('admin.desserts.create') }}">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea il Primo Dessert
          </a>
        </div>
      </div>
    </div>
  @else
    {{-- Container che cambia layout in base al toggle --}}
    <div id="desserts-container" class="transition-container">
      
      {{-- Vista a Elenco (default) --}}
      <div id="desserts-list-view" class="view-mode active" role="region" aria-label="Vista a elenco dei dolci">
        <div class="list-container">
          @foreach($desserts as $d)
            <div class="list-item-pizza border-bottom py-3">
              <div class="row align-items-center">
                <div class="col-md-2 col-3">
                  @if(!empty($d->image_path))
                    <img src="{{ asset('storage/'.$d->image_path) }}" 
                         alt="Dolce {{ $d->name }}" 
                         class="img-fluid rounded" style="height:60px;width:60px;object-fit:cover;">
                  @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:60px;width:60px;">
                      <i class="fas fa-cookie-bite text-muted"></i>
                    </div>
                  @endif
                </div>
                <div class="col-md-5 col-6">
                  <h6 class="mb-1 fw-bold">
                    <a href="{{ route('admin.desserts.show', $d) }}" class="text-decoration-none text-dark">
                      {{ $d->name }}
                    </a>
                  </h6>
                  <small class="text-muted d-block">{{ $d->description ?? 'Nessuna descrizione' }}</small>
                  
                  {{-- Allergeni compatti --}}
                  <div class="mt-1">
                    <x-allergen-display :allergens="$d" mode="minimal" :maxVisible="3" />
                  </div>
                </div>
                <div class="col-md-2 col-3 text-center">
                  <span class="h6 text-success fw-bold">€{{ number_format($d->price ?? 0, 2, ',', '.') }}</span>
                  @if(!empty($d->is_gluten_free))
                    <br><small class="badge bg-info text-dark">🌾 Senza Glutine</small>
                  @endif
                </div>
                <div class="col-md-3 col-12 mt-2 mt-md-0">
                  <div class="btn-group btn-group-sm w-100">
                    <a href="{{ route('admin.desserts.show', $d) }}" class="btn btn-view btn-sm flex-fill">
                      <i class="fas fa-eye me-1" aria-hidden="true"></i>
                      <span class="d-none d-sm-inline">Dettagli</span>
                    </a>
                    <a href="{{ route('admin.desserts.edit', $d) }}" class="btn btn-edit btn-sm flex-fill">
                      <i class="fas fa-edit me-1" aria-hidden="true"></i>
                      <span class="d-none d-sm-inline">Modifica</span>
                    </a>
                    <form method="POST" action="{{ route('admin.desserts.destroy', $d) }}" class="flex-fill d-inline"
                          onsubmit="return confirm('Eliminare definitivamente {{ $d->name }}?')">
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
      <div id="desserts-card-view" class="view-mode" role="region" aria-label="Vista a griglia dei dolci" style="display: none;">
        <div class="row g-4">
          @foreach($desserts as $d)
            <div class="col-12 col-md-6 col-xl-4">
              <div class="card h-100 border-0 shadow-sm">
                @if(!empty($d->image_path))
                  <div class="position-relative">
                    <img src="{{ asset('storage/'.$d->image_path) }}"
                         alt="Immagine dolce {{ $d->name }}"
                         class="card-img-top" style="height:200px;object-fit:cover;">
                    @if(!empty($d->is_gluten_free))
                      <span class="position-absolute top-0 start-0 badge bg-info text-dark m-2">
                        🌾 Senza Glutine
                      </span>
                    @endif
                  </div>
                @else
                  <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                    <div class="text-center text-muted">
                      <i class="fas fa-cookie-bite fs-1 mb-2"></i>
                      <div class="small">Nessuna immagine</div>
                    </div>
                  </div>
                @endif

                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <a href="{{ route('admin.desserts.show', $d) }}"
                       class="h5 mb-0 text-decoration-none fw-bold text-dark">
                      {{ $d->name }}
                    </a>
                    <div class="h5 mb-0 text-success fw-bold">
                      €{{ number_format($d->price ?? 0, 2, ',', '.') }}
                    </div>
                  </div>

                  @if(!empty($d->description))
                    <p class="card-text text-muted mb-3" style="line-height:1.5;">
                      {{ \Illuminate\Support\Str::limit($d->description, 120) }}
                    </p>
                  @endif

                  {{-- Sistema allergeni semantico --}}
                  <div class="mb-3">
                    <x-allergen-display :allergens="$d" mode="compact" :maxVisible="3" />
                  </div>

                  <div class="d-flex gap-2 mt-auto">
                    <a class="btn btn-view btn-sm flex-fill"
                       href="{{ route('admin.desserts.show', $d) }}"
                       data-bs-toggle="tooltip" title="Dettagli">
                      <i class="fas fa-eye me-1" aria-hidden="true"></i> Dettagli
                    </a>
                    <a class="btn btn-edit btn-sm flex-fill"
                       href="{{ route('admin.desserts.edit', $d) }}"
                       data-bs-toggle="tooltip" title="Modifica">
                      <i class="fas fa-edit me-1" aria-hidden="true"></i> Modifica
                    </a>
                    <form method="POST" action="{{ route('admin.desserts.destroy', $d) }}" class="flex-fill"
                          onsubmit="return confirm('Eliminare definitivamente {{ $d->name }}?')">
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

    @if(method_exists($desserts,'hasPages') && $desserts->hasPages())
      <div class="d-flex justify-content-center mt-5">
        {{ $desserts->links() }}
      </div>
    @endif
  @endif
@endsection
