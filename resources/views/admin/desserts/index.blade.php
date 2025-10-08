@extends('layouts.app-modern')

@section('title', 'I Tuoi Dessert')

@section('header')
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🍰</div>
  <h1 class="display-6 fw-bold text-dark mb-2">I Tuoi Dolci</h1>
  <p class="lead text-muted mb-4">Tiramisù, gelati e delizie dolci</p>

  {{-- CTA crea --}}
  <div class="d-flex justify-content-center mb-4">
    <a href="{{ route('admin.desserts.create') }}"
       class="btn btn-create btn-lg px-4 py-3"
       role="button"
       aria-label="Aggiungi un nuovo dolce"
       data-bs-toggle="tooltip" title="Crea un nuovo dolce">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuovo Dolce
    </a>
  </div>

  {{-- Announcer + contatore --}}
  <div class="visually-hidden" aria-live="polite" aria-atomic="true" id="view-change-announce"></div>
  <div class="mt-3">
    @php $total = method_exists($desserts,'total') ? $desserts->total() : ($desserts->count() ?? 0); @endphp
    <span class="badge bg-success fs-6 px-3 py-2">Hai {{ $total }} {{ $total == 1 ? 'dolce' : 'dolci' }} nel menu</span>
  </div>
</div>
@endsection

@section('content')
  @php $count = ($desserts->count() ?? 0); @endphp

  @if($count === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🍰</div>
          <h3 class="fw-bold text-dark mb-3">Nessun dessert presente</h3>
          <p class="text-muted mb-4">Aggiungi il primo dolce al tuo menu.</p>
          <a class="btn btn-success btn-lg px-4 py-3 fw-bold" href="{{ route('admin.desserts.create') }}">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea il Primo Dessert
          </a>
        </div>
      </div>
    </div>
  @else
    <div id="desserts-container" class="transition-container list-wrapper">

      <div class="list-container">
        @foreach($desserts as $d)
          <div class="list-item-dessert py-3 border-bottom">
            <div class="row align-items-center g-3">
              {{-- IMG --}}
              <div class="col-md-2 col-3">
                @if(!empty($d->image_path))
                  <img src="{{ asset('storage/'.$d->image_path) }}" alt="Dolce {{ $d->name }}" class="img-fluid rounded" style="height:60px;width:60px;object-fit:cover;">
                @else
                  <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:60px;width:60px;">
                    <i class="fas fa-cookie-bite text-muted" aria-hidden="true"></i>
                  </div>
                @endif
              </div>

              {{-- TESTO + BADGE --}}
              <div class="col-md-5 col-6">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1 min-w-0">
                    <h6 class="mb-1 fw-bold text-truncate">
                      <a href="{{ route('admin.desserts.show', $d) }}" class="text-decoration-none text-dark">{{ $d->name }}</a>
                    </h6>
                    <small class="text-muted d-block text-truncate">{{ $d->description ?? 'Nessuna descrizione' }}</small>

                    @if (\Illuminate\Support\Facades\View::exists('components.allergen-display'))
                      <div class="mt-1">
                        <x-allergen-display :allergens="$d" mode="minimal" :maxVisible="3" />
                      </div>
                    @endif
                  </div>

                  @if(!empty($d->is_gluten_free))
                    <span class="badge bg-info text-dark ms-2" title="Senza glutine">🌾 Senza Glutine</span>
                  @endif
                </div>
              </div>

              {{-- PREZZO --}}
              <div class="col-md-2 col-3 text-center">
                <span class="h6 text-success fw-bold">€{{ number_format($d->price ?? 0, 2, ',', '.') }}</span>
              </div>

              {{-- AZIONI (no .btn-group per evitare clipping) --}}
              <div class="col-md-3 col-12">
                <div class="d-flex flex-wrap gap-2 w-100 actions-flex">
                  <a href="{{ route('admin.desserts.show', $d) }}"
                     class="btn btn-view btn-sm flex-grow-1"
                     data-bs-toggle="tooltip" title="Dettagli">
                    <i class="fas fa-eye me-1"></i><span class="d-none d-lg-inline">Dettagli</span>
                  </a>

                  <a href="{{ route('admin.desserts.edit', $d) }}"
                     class="btn btn-edit btn-sm flex-grow-1"
                     data-bs-toggle="tooltip" title="Modifica">
                    <i class="fas fa-edit me-1"></i><span class="d-none d-lg-inline">Modifica</span>
                  </a>

                  <form method="POST"
                        action="{{ route('admin.desserts.destroy', $d) }}"
                        class="flex-grow-1"
                        onsubmit="return confirm('Eliminare definitivamente {{ $d->name }}?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="btn btn-delete btn-sm w-100 d-flex align-items-center justify-content-center"
                            data-bs-toggle="tooltip" title="Elimina">
                      <i class="fas fa-trash me-1"></i><span>Elimina</span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      @if(method_exists($desserts,'hasPages') && $desserts->hasPages())
        <div class="d-flex justify-content-center mt-5">{{ $desserts->links() }}</div>
      @endif
    </div>
  @endif
@endsection

@push('styles')
<style>
  /* Evita qualsiasi clipping dell'elenco */
  .list-wrapper, .list-container { overflow: visible; }
  /* Migliora la resa su layout stretti */
  .actions-flex .btn { min-width: 110px; white-space: nowrap; }
  @media (max-width: 576px) {
    .actions-flex .btn { min-width: 100%; }
  }
</style>
@endpush

@push('scripts')
<script>
(function () {
  if (window.bootstrap) {
    const triggers = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    triggers.forEach(el => new bootstrap.Tooltip(el));
  }
})();
</script>
@endpush
