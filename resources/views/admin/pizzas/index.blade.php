@extends('layouts.app-modern')

@section('title', 'Pizze')

@section('header')
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🍕</div>
  <h1 class="display-6 fw-bold text-dark mb-2">Pizze</h1>
  <p class="lead text-muted mb-4">Gestisci le pizze del tuo menu</p>

  <div class="d-flex justify-content-center mb-4">
    <a href="{{ route('admin.pizzas.create') }}"
       class="btn btn-create btn-lg px-4 py-3"
       role="button"
       aria-label="Aggiungi una nuova pizza"
       data-bs-toggle="tooltip" title="Crea una nuova pizza">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuova Pizza
    </a>
  </div>

  <div class="mt-3">
    @php $total = method_exists($pizzas,'total') ? $pizzas->total() : ($pizzas->count() ?? 0); @endphp
    <span class="badge bg-success fs-6 px-3 py-2">Hai {{ $total }} {{ $total == 1 ? 'pizza' : 'pizze' }} disponibili</span>
  </div>
</div>
@endsection

@section('content')
  @php $count = ($pizzas->count() ?? 0); @endphp

  @if($count === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🍕</div>
          <h3 class="fw-bold text-dark mb-3">Nessuna pizza presente</h3>
          <p class="text-muted mb-4">Crea la tua prima pizza per iniziare.</p>
          <a class="btn btn-success btn-lg px-4 py-3 fw-bold" href="{{ route('admin.pizzas.create') }}">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea la Prima Pizza
          </a>
        </div>
      </div>
    </div>
  @else
    <div class="transition-container list-wrapper">
      <div class="list-container">
        @foreach($pizzas as $pizza)
          <div class="border-bottom py-3">
            <div class="row align-items-center g-3">
              <div class="col-md-2 col-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:60px;width:60px;">
                  <i class="fas fa-pizza-slice text-muted" aria-hidden="true"></i>
                </div>
              </div>

              <div class="col-md-7 col-9">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1 min-w-0">
                    <h6 class="mb-1 fw-bold text-truncate">{{ $pizza->name }}</h6>
                    @if(!empty($pizza->notes))
                      <small class="text-muted d-block text-truncate">{{ \Illuminate\Support\Str::limit($pizza->notes, 120) }}</small>
                    @endif

                    @if($pizza->ingredients && $pizza->ingredients->count() > 0)
                      <div class="mt-2">
                        <small class="text-muted">Ingredienti:</small>
                        <div class="mt-1">
                          @foreach($pizza->ingredients->take(3) as $ingredient)
                            <span class="badge bg-primary text-white me-1 mb-1">{{ $ingredient->name }}</span>
                          @endforeach
                          @if($pizza->ingredients->count() > 3)
                            <span class="badge bg-secondary">+{{ $pizza->ingredients->count() - 3 }}</span>
                          @endif
                        </div>
                      </div>
                    @endif
                  </div>
                  @if($pizza->category)
                    <span class="badge bg-info text-dark ms-2">{{ $pizza->category->name }}</span>
                  @endif
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="d-flex flex-wrap gap-2 w-100 actions-flex">
                  <a href="{{ route('admin.pizzas.show', $pizza) }}" class="btn btn-view btn-sm flex-grow-1" data-bs-toggle="tooltip" title="Dettagli">
                    <i class="fas fa-eye me-1"></i><span class="d-none d-lg-inline">Dettagli</span>
                  </a>
                  <a href="{{ route('admin.pizzas.edit', $pizza) }}" class="btn btn-edit btn-sm flex-grow-1" data-bs-toggle="tooltip" title="Modifica">
                    <i class="fas fa-edit me-1"></i><span class="d-none d-lg-inline">Modifica</span>
                  </a>
                  <form method="POST" action="{{ route('admin.pizzas.destroy', $pizza) }}" class="flex-grow-1" onsubmit="return confirm('Eliminare definitivamente {{ $pizza->name }}?')">
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

      @if(method_exists($pizzas,'hasPages') && $pizzas->hasPages())
        <div class="d-flex justify-content-center mt-5">{{ $pizzas->links() }}</div>
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
