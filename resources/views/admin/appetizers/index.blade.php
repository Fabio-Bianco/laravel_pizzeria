@extends('layouts.app-modern')

@section('title', 'I Tuoi Antipasti')

@section('header')
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🥗</div>
  <h1 class="display-6 fw-bold text-dark mb-2">I Tuoi Antipasti</h1>
  <p class="lead text-muted mb-4">Tutti gli antipasti e stuzzichini del tuo menu</p>

  <div class="d-flex justify-content-center mb-4">
    <a href="{{ route('admin.appetizers.create') }}"
       class="btn btn-create btn-lg px-4 py-3"
       role="button"
       aria-label="Aggiungi un nuovo antipasto"
       data-bs-toggle="tooltip" title="Crea un nuovo antipasto">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuovo Antipasto
    </a>
  </div>

  <div class="visually-hidden" aria-live="polite" aria-atomic="true" id="view-change-announce"></div>
  <div class="mt-3">
    @php $total = method_exists($appetizers,'total') ? $appetizers->total() : ($appetizers->count() ?? 0); @endphp
    <span class="badge bg-success fs-6 px-3 py-2">Hai {{ $total }} {{ $total == 1 ? 'antipasto' : 'antipasti' }} nel menu</span>
  </div>
</div>
@endsection

@section('content')
  @php $count = ($appetizers->count() ?? 0); @endphp

  @if($count === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🥗</div>
          <h3 class="fw-bold text-dark mb-3">Non hai ancora nessun antipasto!</h3>
          <p class="text-muted mb-4">Inizia subito creando il tuo primo antipasto per il menu.</p>
          <a class="btn btn-success btn-lg px-4 py-3 fw-bold" href="{{ route('admin.appetizers.create') }}">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea il Primo Antipasto
          </a>
        </div>
      </div>
    </div>
  @else
    <div id="appetizers-container" class="transition-container list-wrapper">
      <div class="list-container">
        @foreach($appetizers as $a)
          <div class="list-item-appetizer border-bottom py-3">
            <div class="row align-items-center g-3">
              <div class="col-md-2 col-3">
                @if(!empty($a->image_path))
                  <img src="{{ asset('storage/'.$a->image_path) }}" alt="Antipasto {{ $a->name }}" class="img-fluid rounded" style="height:60px;width:60px;object-fit:cover;">
                @else
                  <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:60px;width:60px;">
                    <i class="fas fa-seedling text-muted" aria-hidden="true"></i>
                  </div>
                @endif
              </div>

              <div class="col-md-4 col-6">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1 min-w-0">
                    <h6 class="mb-1 fw-bold text-truncate">
                      <a href="{{ route('admin.appetizers.show', $a) }}" class="text-decoration-none text-dark">{{ $a->name }}</a>
                    </h6>
                    <small class="text-muted d-block text-truncate">{{ $a->description ?? 'Nessuna descrizione' }}</small>
                    @if (\Illuminate\Support\Facades\View::exists('components.allergen-display'))
                      <div class="mt-1"><x-allergen-display :allergens="$a" mode="minimal" :maxVisible="3" /></div>
                    @endif
                  </div>
                  @if(!empty($a->is_vegan))
                    <span class="badge bg-success bg-opacity-10 border border-success text-success ms-2" title="Antipasto vegano" aria-label="Questo antipasto è vegano">
                      <i class="fas fa-leaf me-1" aria-hidden="true"></i>Vegano
                    </span>
                  @endif
                </div>
              </div>

              <div class="col-md-2 col-3 text-center">
                <span class="h6 text-success fw-bold">€{{ number_format($a->price ?? 0, 2, ',', '.') }}</span>
              </div>

              <div class="col-md-4 col-12">
                <div class="d-flex flex-wrap gap-2 w-100 actions-flex">
                  <a href="{{ route('admin.appetizers.show', $a) }}" class="btn btn-view btn-sm flex-grow-1" data-bs-toggle="tooltip" title="Dettagli">
                    <i class="fas fa-eye me-1"></i><span class="d-none d-lg-inline">Dettagli</span>
                  </a>
                  <a href="{{ route('admin.appetizers.edit', $a) }}" class="btn btn-edit btn-sm flex-grow-1" data-bs-toggle="tooltip" title="Modifica">
                    <i class="fas fa-edit me-1"></i><span class="d-none d-lg-inline">Modifica</span>
                  </a>
                  <form method="POST" action="{{ route('admin.appetizers.destroy', $a) }}" class="flex-grow-1" onsubmit="return confirm('Eliminare definitivamente {{ $a->name }}?')">
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

      @if(method_exists($appetizers,'hasPages') && $appetizers->hasPages())
        <div class="d-flex justify-content-center mt-5">{{ $appetizers->links() }}</div>
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
