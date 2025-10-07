@extends('layouts.app-modern')

@section('title', 'Le Tue Bevande')

@section('header')
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🥤</div>
  <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Bevande</h1>
  <p class="lead text-muted mb-4">Acqua, bibite, birre, vini e altro</p>

  <div class="d-flex justify-content-center">
    <a href="{{ route('admin.beverages.create') }}"
       class="btn btn-create btn-lg px-4 py-3"
       title="Aggiungi bevanda" data-bs-toggle="tooltip">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuova Bevanda
    </a>
  </div>

  <div class="mt-3">
    @php $total = method_exists($beverages,'total') ? $beverages->total() : ($beverages->count() ?? 0); @endphp
    <span class="badge badge-success fs-6 px-3 py-2">
      Hai {{ $total }} {{ $total == 1 ? 'bevanda' : 'bevande' }} nel menu
    </span>
  </div>
</div>
@endsection

@section('content')
  @if(($beverages->count() ?? 0) === 0)
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🥤</div>
          <h3 class="fw-bold text-dark mb-3">Nessuna bevanda presente</h3>
          <p class="text-muted mb-4">Aggiungi la prima bevanda alla carta.</p>
          <a class="btn btn-create btn-lg px-4 py-3" href="{{ route('admin.beverages.create') }}">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea la Prima Bevanda
          </a>
        </div>
      </div>
    </div>
  @else
    <div class="row g-4">
      @foreach($beverages as $b)
        <div class="col-12 col-md-6 col-xl-4">
          <div class="card h-100 border-0 shadow-sm">
            @if(!empty($b->image_path))
              <div class="position-relative">
                <img src="{{ asset('storage/'.$b->image_path) }}"
                     alt="Immagine bevanda {{ $b->name }}"
                     class="card-img-top" style="height:200px;object-fit:cover;">
                @if(!empty($b->is_alcoholic))
                  <span class="position-absolute top-0 start-0 badge bg-danger text-white m-2">
                    18+
                  </span>
                @endif
              </div>
            @else
              <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                <div class="text-center text-muted">
                  <i class="fas fa-wine-glass-alt fs-1 mb-2"></i>
                  <div class="small">Nessuna immagine</div>
                </div>
              </div>
            @endif

            <div class="card-body d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <a href="{{ route('admin.beverages.show', $b) }}"
                   class="h5 mb-0 text-decoration-none fw-bold text-dark">
                  {{ $b->name }}
                </a>
                <div class="h5 mb-0 text-success fw-bold">
                  €{{ number_format($b->price ?? 0, 2, ',', '.') }}
                </div>
              </div>

              @if(!empty($b->description))
                <p class="card-text text-muted mb-3">
                  {{ \Illuminate\Support\Str::limit($b->description, 120) }}
                </p>
              @endif

              <div class="d-flex gap-2 mt-auto">
                <a class="btn btn-view btn-sm flex-fill"
                   href="{{ route('admin.beverages.show', $b) }}"
                   data-bs-toggle="tooltip" title="Dettagli">
                  <i class="fas fa-eye me-1" aria-hidden="true"></i> Dettagli
                </a>
                <a class="btn btn-edit btn-sm flex-fill"
                   href="{{ route('admin.beverages.edit', $b) }}"
                   data-bs-toggle="tooltip" title="Modifica">
                  <i class="fas fa-edit me-1" aria-hidden="true"></i> Modifica
                </a>
                <form method="POST" action="{{ route('admin.beverages.destroy', $b) }}" class="flex-fill"
                      onsubmit="return confirm('Eliminare definitivamente {{ $b->name }}?')">
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

    @if(method_exists($beverages,'hasPages') && $beverages->hasPages())
      <div class="d-flex justify-content-center mt-5">
        {{ $beverages->links() }}
      </div>
    @endif
  @endif
@endsection
