@extends('layouts.app-modern')

@section('title', 'Le Tue Bevande')

@section('header')
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🥤</div>
  <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Bevande</h1>
  <p class="lead text-muted mb-4">Bibite, vini e birre del tuo menu</p>

  <div class="d-flex justify-content-center mb-4">
    <a href="{{ route('admin.beverages.create') }}"
       class="btn btn-create btn-lg px-4 py-3"
       role="button"
       aria-label="Aggiungi una nuova bevanda"
       data-bs-toggle="tooltip" title="Crea una nuova bevanda">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuova Bevanda
    </a>
  </div>

  <div class="visually-hidden" aria-live="polite" aria-atomic="true" id="view-change-announce"></div>
  <div class="mt-3">
    @php $total = method_exists($beverages,'total') ? $beverages->total() : ($beverages->count() ?? 0); @endphp
    <span class="badge bg-success fs-6 px-3 py-2">Hai {{ $total }} {{ $total == 1 ? 'bevanda' : 'bevande' }} nel menu</span>
  </div>
</div>
@endsection

@section('content')
  @php $count = ($beverages->count() ?? 0); @endphp

  @if($count === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🥤</div>
          <h3 class="fw-bold text-dark mb-3">Nessuna bevanda presente</h3>
          <p class="text-muted mb-4">Aggiungi la prima bevanda al tuo menu.</p>
          <a class="btn btn-success btn-lg px-4 py-3 fw-bold" href="{{ route('admin.beverages.create') }}">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea la Prima Bevanda
          </a>
        </div>
      </div>
    </div>
  @else
    <div id="beverages-container" class="transition-container list-wrapper">
      <div class="list-container">
        @foreach($beverages as $b)
          <div class="list-item-beverage border-bottom py-3">
            <div class="row align-items-center g-3">
              <div class="col-md-2 col-3">
                @if(!empty($b->image_path))
                  <img src="{{ asset('storage/'.$b->image_path) }}" alt="Bevanda {{ $b->name }}" class="img-fluid rounded" style="height:60px;width:60px;object-fit:cover;">
                @else
                  <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:60px;width:60px;">
                    <i class="fas fa-wine-bottle text-muted" aria-hidden="true"></i>
                  </div>
                @endif
              </div>

              <div class="col-md-5 col-6">
                <div class="flex-grow-1 min-w-0">
                  <h6 class="mb-1 fw-bold text-truncate">
                    <a href="{{ route('admin.beverages.show', $b) }}" class="text-decoration-none text-dark">{{ $b->name }}</a>
                  </h6>
                  <small class="text-muted d-block text-truncate">{{ $b->description ?? 'Nessuna descrizione' }}</small>
                </div>
              </div>

              <div class="col-md-2 col-3 text-center">
                <span class="h6 text-success fw-bold">€{{ number_format($b->price ?? 0, 2, ',', '.') }}</span>
              </div>

              <div class="col-md-3 col-12">
                <div class="d-flex flex-wrap gap-2 w-100 actions-flex">
                  <a href="{{ route('admin.beverages.show', $b) }}" class="btn btn-view btn-sm flex-grow-1" data-bs-toggle="tooltip" title="Dettagli">
                    <i class="fas fa-eye me-1"></i><span class="d-none d-lg-inline">Dettagli</span>
                  </a>
                  <a href="{{ route('admin.beverages.edit', $b) }}" class="btn btn-edit btn-sm flex-grow-1" data-bs-toggle="tooltip" title="Modifica">
                    <i class="fas fa-edit me-1"></i><span class="d-none d-lg-inline">Modifica</span>
                  </a>
                  <form method="POST" action="{{ route('admin.beverages.destroy', $b) }}" class="flex-grow-1" onsubmit="return confirm('Eliminare definitivamente {{ $b->name }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-delete btn-sm w-100 d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Elimina">
                      <i class="fas fa-trash me-1"></i><span>Elimina</span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      @if(method_exists($beverages,'hasPages') && $beverages->hasPages())
        <div class="d-flex justify-content-center mt-5">{{ $beverages->links() }}</div>
      @endif
    </div>
  @endif
@endsection

@push('styles')
<style>
  .list-wrapper, .list-container { overflow: visible; }
  .actions-flex .btn { min-width: 110px; white-space: nowrap; }
  @media (max-width: 576px) { .actions-flex .btn { min-width: 100%; } }
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
