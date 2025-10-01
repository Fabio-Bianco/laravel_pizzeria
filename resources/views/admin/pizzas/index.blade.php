<x-app-layout>
  <x-slot name="header">
    <x-page-header title="Pizze" :items="[['label' => 'Pizze']]">
      <x-slot name="actions">
        <a class="btn btn-primary" href="{{ route('admin.pizzas.create') }}">+ Nuova pizza</a>
      </x-slot>
    </x-page-header>
  </x-slot>

  @include('partials.flash')

  {{-- Toolbar filtri riutilizzabile --}}
  <x-filter-toolbar
    search
    searchPlaceholder="Cerca per nome o descrizione…"
    :selects="[
      ['name' => 'category', 'placeholder' => 'Tutte le categorie', 'options' => ($filters['categories'] ?? [])],
      ['name' => 'ingredient', 'placeholder' => 'Qualsiasi ingrediente', 'options' => ($filters['ingredients'] ?? [])],
    ]"
    :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A', 'price_asc' => 'Prezzo ↑', 'price_desc' => 'Prezzo ↓']"
    :reset-url="route('admin.pizzas.index')"
  />

  {{-- Griglia card pizze --}}
  <div class="row g-3" aria-live="polite">
    @forelse($pizzas as $p)
      <div class="col-12 col-md-6 col-lg-4">
  <div class="card h-100 d-flex" role="article" aria-label="Scheda pizza {{ $p->name }}">
          @if($p->image_path)
            <img src="{{ asset('storage/'.$p->image_path) }}" alt="Immagine pizza {{ $p->name }}" class="card-img-top" style="height:180px;object-fit:cover;">
          @endif
          <div class="card-body d-flex flex-column">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <a href="{{ route('admin.pizzas.show', $p) }}" class="fw-semibold text-decoration-none">{{ $p->name }}</a>
              <div class="d-flex align-items-center gap-2">
                @if($p->category?->is_white)
                  <span class="badge text-bg-warning-subtle text-warning-emphasis" title="Pizza bianca">Bianca</span>
                @endif
                <span class="badge text-bg-secondary">{{ $p->category?->name ?? '—' }}</span>
              </div>
            </div>
            
              @php($ingredientNames = $p->ingredients->pluck('name'))
              @php($ingStr = $ingredientNames->isNotEmpty() ? $ingredientNames->join(', ') : 'Nessuno')
              <div class="text-muted small mb-2" title="{{ $ingStr }}">
                {{ \Illuminate\Support\Str::limit($ingStr, 80) }}
            </div>
              @php(
                $allergenNames = collect($p->ingredients)
                  ->flatMap(fn($ing) => $ing->allergens->pluck('name'))
                  ->unique()
                  ->values()
              )
              @php($allStr = $allergenNames->isNotEmpty() ? $allergenNames->join(', ') : 'Nessuno')
              <div class="text-muted small mb-2" title="{{ $allStr }}">
              <span class="fw-semibold">Allergeni:</span>
              {{ \Illuminate\Support\Str::limit($allStr, 80) }}
            </div>
            @if(!empty($p->notes))
              <div class="alert alert-warning py-1 px-2 mb-2 small" role="note">
                <span class="fw-semibold">Nota:</span> {{ $p->notes }}
              </div>
            @endif
            <div class="d-flex justify-content-between align-items-center mt-auto">
              <div class="d-flex align-items-center gap-2">
                @php($priceStr = '€ '.number_format($p->price, 2, ',', '.'))
                <span class="fw-semibold" aria-label="Prezzo {{ $priceStr }}"><span class="visually-hidden">Prezzo:</span> {{ $priceStr }}</span>
              </div>
              <div class="d-flex gap-2">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.pizzas.edit', $p) }}" aria-label="Modifica pizza {{ $p->name }}">Modifica</a>
                <form class="d-inline" method="POST" action="{{ route('admin.pizzas.destroy', $p) }}" data-confirm="Sicuro?">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" type="submit" aria-label="Elimina pizza {{ $p->name }}">Elimina</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info text-center mb-0">Nessuna pizza trovata.</div>
      </div>
    @endforelse
  </div>

  @if($pizzas->hasPages())
    <div class="mt-3 d-flex justify-content-center">
      {{ $pizzas->links() }}
    </div>
  @endif
</x-app-layout>
