@extends('layouts.app-modern')

@section('title', 'I Tuoi Antipasti')

@section('header')
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🥗</div>
  <h1 class="display-6 fw-bold text-dark mb-2">I Tuoi Antipasti</h1>
  <p class="lead text-muted mb-4">Tutti gli antipasti e stuzzichini del tuo menu</p>

  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
    <a href="{{ route('admin.appetizers.create') }}"
       class="btn btn-create btn-lg px-4 py-3"
       title="Clicca per aggiungere un nuovo antipasto"
       data-bs-toggle="tooltip">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuovo Antipasto
    </a>
    
    {{-- Toggle Layout View --}}
    <div class="view-toggle-controls" role="group" aria-label="Seleziona vista visualizzazione">
      <div class="btn-group" role="radiogroup" aria-label="Modalità visualizzazione antipasti">
        <input type="radio" class="btn-check" name="appetizersViewMode" id="appetizersListView" value="list" checked>
        <label class="btn btn-outline-secondary" for="appetizersListView" 
               title="Visualizzazione a elenco" 
               aria-label="Cambia a visualizzazione a elenco">
          <i class="fas fa-list me-1" aria-hidden="true"></i>
          <span class="d-none d-sm-inline">Elenco</span>
        </label>

        <input type="radio" class="btn-check" name="appetizersViewMode" id="appetizersCardView" value="card">
        <label class="btn btn-outline-secondary" for="appetizersCardView" 
               title="Visualizzazione a griglia" 
               aria-label="Cambia a visualizzazione a griglia">
          <i class="fas fa-th-large me-1" aria-hidden="true"></i>
          <span class="d-none d-sm-inline">Griglia</span>
        </label>
      </div>
    </div>
  </div>

  <div class="mt-3">
    @php $total = method_exists($appetizers,'total') ? $appetizers->total() : ($appetizers->count() ?? 0); @endphp
    <span class="badge bg-success fs-6 px-3 py-2">
      Hai {{ $total }} {{ $total == 1 ? 'antipasto' : 'antipasti' }} nel menu
    </span>
  </div>
</div>
@endsection

@section('content')
  @if(($appetizers->count() ?? 0) === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🥗</div>
          <h3 class="fw-bold text-dark mb-3">Non hai ancora nessun antipasto!</h3>
          <p class="text-muted mb-4">Inizia subito creando il tuo primo antipasto per il menu.</p>
          <a class="btn btn-success btn-lg px-4 py-3 fw-bold" href="{{ route('admin.appetizers.create') }}">
            <i class="fas fa-rocket me-2"></i> Crea il Primo Antipasto
          </a>
        </div>
      </div>
    </div>
  @else
    {{-- Container che cambia layout in base al toggle --}}
    <div id="appetizers-container" class="transition-container">
      
      {{-- Vista a Elenco (default) --}}
      <div id="appetizers-list-view" class="view-mode active" role="region" aria-label="Vista a elenco degli antipasti">
        <div class="list-container">
          @foreach($appetizers as $a)
            <div class="list-item-pizza border-bottom py-3">
              <div class="row align-items-center">
                <div class="col-md-2 col-3">
                  @if(!empty($a->image_path))
                    <img src="{{ asset('storage/'.$a->image_path) }}" 
                         alt="Antipasto {{ $a->name }}" 
                         class="img-fluid rounded" style="height:60px;width:60px;object-fit:cover;">
                  @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:60px;width:60px;">
                      <i class="fas fa-seedling text-muted"></i>
                    </div>
                  @endif
                </div>
                <div class="col-md-5 col-6">
                  <h6 class="mb-1 fw-bold">
                    <a href="{{ route('admin.appetizers.show', $a) }}" class="text-decoration-none text-dark">
                      {{ $a->name }}
                    </a>
                  </h6>
                  <small class="text-muted d-block">{{ $a->description ?? 'Nessuna descrizione' }}</small>
                  
                  {{-- Ingredienti in vista compatta --}}
                  @if(!empty($a->ingredients) && $a->ingredients->isNotEmpty())
                    <div class="mt-1">
                      <small class="text-muted">
                        <i class="fas fa-seedling me-1" aria-hidden="true"></i>
                        {{ $a->ingredients->take(3)->pluck('name')->join(', ') }}
                        @if($a->ingredients->count() > 3)
                          <span class="badge bg-info text-white ms-1" style="font-size: 10px;">
                            +{{ $a->ingredients->count() - 3 }}
                          </span>
                        @endif
                      </small>
                    </div>
                  @endif
                  
                  {{-- Allergeni compatti --}}
                  <div class="mt-1">
                    <x-allergen-display :allergens="$a" mode="minimal" :maxVisible="3" />
                  </div>
                </div>
                <div class="col-md-2 col-3 text-center">
                  <span class="h6 text-success fw-bold">€{{ number_format($a->price ?? 0, 2, ',', '.') }}</span>
                  @if(!empty($a->is_vegan))
                    <br><small class="badge bg-success text-white">🌱 Vegano</small>
                  @endif
                </div>
                <div class="col-md-3 col-12 mt-2 mt-md-0">
                  <div class="btn-group btn-group-sm w-100">
                    <a href="{{ route('admin.appetizers.show', $a) }}" class="btn btn-view btn-sm flex-fill">
                      <i class="fas fa-eye me-1" aria-hidden="true"></i>
                      <span class="d-none d-sm-inline">Dettagli</span>
                    </a>
                    <a href="{{ route('admin.appetizers.edit', $a) }}" class="btn btn-edit btn-sm flex-fill">
                      <i class="fas fa-edit me-1" aria-hidden="true"></i>
                      <span class="d-none d-sm-inline">Modifica</span>
                    </a>
                    <form method="POST" action="{{ route('admin.appetizers.destroy', $a) }}" class="flex-fill d-inline"
                          onsubmit="return confirm('Eliminare definitivamente {{ $a->name }}?')">
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
      <div id="appetizers-card-view" class="view-mode" role="region" aria-label="Vista a griglia degli antipasti" style="display: none;">
        <div class="row g-4">
          @foreach($appetizers as $a)
            <div class="col-12 col-md-6 col-xl-4">
              <div class="card h-100 border-0 shadow-sm">
                @if(!empty($a->image_path))
                  <div class="position-relative">
                    <img src="{{ asset('storage/'.$a->image_path) }}"
                         alt="Immagine antipasto {{ $a->name }}"
                         class="card-img-top" style="height:200px;object-fit:cover;">
                    @if(!empty($a->is_vegan))
                      <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">
                        <i class="fas fa-leaf me-1"></i> Vegano
                      </span>
                    @endif
                  </div>
                @else
                  <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                    <div class="text-center text-muted">
                      <i class="fas fa-seedling fs-1 mb-2"></i>
                      <div class="small">Nessuna immagine</div>
                    </div>
                  </div>
                @endif

                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <a href="{{ route('admin.appetizers.show', $a) }}"
                       class="h5 mb-0 text-decoration-none fw-bold text-dark">
                      {{ $a->name }}
                    </a>
                    <div class="h5 mb-0 text-success fw-bold">
                      €{{ number_format($a->price ?? 0, 2, ',', '.') }}
                    </div>
                  </div>

                  @if(!empty($a->description))
                    <p class="card-text text-muted mb-3" style="line-height:1.5;">
                      {{ \Illuminate\Support\Str::limit($a->description, 120) }}
                    </p>
                  @endif

                  @if(!empty($a->ingredients) && $a->ingredients->isNotEmpty())
                    <div class="mb-3">
                      <div class="small text-muted mb-1">
                        <i class="fas fa-seedling me-1"></i> Ingredienti:
                      </div>
                      <div class="d-flex flex-wrap gap-1">
                        @foreach($a->ingredients->take(3) as $ingredient)
                          <span class="badge bg-light text-dark">{{ $ingredient->name }}</span>
                        @endforeach
                        @if($a->ingredients->count() > 3)
                          <span class="badge bg-info text-white" 
                                role="button"
                                tabindex="0"
                                title="Altri {{ $a->ingredients->count() - 3 }} ingredienti non mostrati"
                                aria-label="Mostra altri {{ $a->ingredients->count() - 3 }} ingredienti di {{ $a->name }}">
                            <i class="fas fa-plus me-1" aria-hidden="true"></i>{{ $a->ingredients->count() - 3 }}
                          </span>
                        @endif
                      </div>
                    </div>
                  @endif

                  {{-- Sistema allergeni semantico --}}
                  <div class="mb-3">
                    <x-allergen-display :allergens="$a" mode="compact" :maxVisible="3" />
                  </div>

                  @if(!empty($a->notes))
                    <div class="alert alert-light border-0 mb-3 py-2 px-3 small">
                      <i class="fas fa-info-circle me-1"></i>
                      <strong>Nota:</strong> {{ \Illuminate\Support\Str::limit($a->notes, 80) }}
                    </div>
                  @endif

                  <div class="d-flex gap-2 mt-auto">
                    <a class="btn btn-view btn-sm flex-fill"
                       href="{{ route('admin.appetizers.show', $a) }}"
                       data-bs-toggle="tooltip" title="Dettagli">
                      <i class="fas fa-eye me-1" aria-hidden="true"></i> Dettagli
                    </a>
                    <a class="btn btn-edit btn-sm flex-fill"
                       href="{{ route('admin.appetizers.edit', $a) }}"
                       data-bs-toggle="tooltip" title="Modifica">
                      <i class="fas fa-edit me-1" aria-hidden="true"></i> Modifica
                    </a>
                    <form method="POST" action="{{ route('admin.appetizers.destroy', $a) }}" class="flex-fill"
                          onsubmit="return confirm('Eliminare definitivamente {{ $a->name }}?')">
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
              @endif

              @if(!empty($a->ingredients) && $a->ingredients->isNotEmpty())
                    </div>

    @if(method_exists($appetizers,'hasPages') && $appetizers->hasPages())
      <div class="d-flex justify-content-center mt-5">
        {{ $appetizers->links() }}
      </div>
    @endif
  @endif
@endsection
              @endif

              {{-- Sistema allergeni semantico per antipasti --}}
              <div class="mb-3">
                <x-allergen-display :allergens="$a" mode="compact" :maxVisible="3" />
              </div>

              @if(!empty($a->notes))
                <div class="alert alert-info py-2 px-3 mb-3 small border-0" role="note">
                  <i class="fas fa-info-circle me-1"></i>
                  <strong>Nota:</strong> {{ \Illuminate\Support\Str::limit($a->notes, 80) }}
                </div>
              @endif

                  <div class="d-flex gap-2 mt-auto">
                    <a class="btn btn-view btn-sm flex-fill"
                       href="{{ route('admin.appetizers.show', $a) }}"
                       data-bs-toggle="tooltip" title="Dettagli">
                      <i class="fas fa-eye me-1" aria-hidden="true"></i> Dettagli
                    </a>
                    <a class="btn btn-edit btn-sm flex-fill"
                       href="{{ route('admin.appetizers.edit', $a) }}"
                       data-bs-toggle="tooltip" title="Modifica">
                      <i class="fas fa-edit me-1" aria-hidden="true"></i> Modifica
                    </a>
                    <form method="POST" action="{{ route('admin.appetizers.destroy', $a) }}" class="flex-fill"
                          onsubmit="return confirm('Eliminare definitivamente {{ $a->name }}?')">
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
      
      {{-- Vista a Elenco --}}
      <div id="appetizers-list-view" class="view-mode" role="region" aria-label="Vista a elenco degli antipasti" style="display: none;">
        <div class="list-container">
          @foreach($appetizers as $a)
            <div class="list-item-pizza border-bottom py-3">
              <div class="row align-items-center">
                <div class="col-2">
                  @if(!empty($a->image_path))
                    <img src="{{ asset('storage/'.$a->image_path) }}" 
                         alt="Antipasto {{ $a->name }}" 
                         class="img-fluid rounded" style="height:60px;width:60px;object-fit:cover;">
                  @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:60px;width:60px;">
                      <i class="fas fa-seedling text-muted"></i>
                    </div>
                  @endif
                </div>
                <div class="col-6">
                  <h6 class="mb-1">{{ $a->name }}</h6>
                  <small class="text-muted">{{ $a->description ?? 'Nessuna descrizione' }}</small>
                </div>
                <div class="col-2 text-center">
                  <span class="h6 text-success">€{{ number_format($a->price ?? 0, 2, ',', '.') }}</span>
                </div>
                <div class="col-2">
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.appetizers.show', $a) }}" class="btn btn-view btn-sm">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.appetizers.edit', $a) }}" class="btn btn-edit btn-sm">
                      <i class="fas fa-edit"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      
    </div>

    @if(method_exists($appetizers,'hasPages') && $appetizers->hasPages())
      <div class="d-flex justify-content-center mt-5">
        {{ $appetizers->links() }}
      </div>
    @endif
  @endif
@endsection
