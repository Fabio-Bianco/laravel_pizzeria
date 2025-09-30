<x-app-layout>
  <x-slot name="header">
    <div class="d-flex align-items-center justify-content-between">
      <h1 class="h4 mb-0">Pizze</h1>
      <a class="btn btn-primary" href="{{ route('admin.pizzas.create') }}">+ Nuova pizza</a>
    </div>
  </x-slot>

  @include('partials.flash')

  <form method="GET" class="card mb-3">
    <div class="card-body">
      <div class="row g-2">
        <div class="col-12 col-md-4">
          <input name="search" type="search" value="{{ request('search') }}" class="form-control" placeholder="Cerca per nome o descrizione…">
        </div>
        <div class="col-6 col-md-3">
          <select name="category" class="form-select" data-choices>
            <option value="">Tutte le categorie</option>
            @foreach($filters['categories'] as $id => $name)
              <option value="{{ $id }}" @selected((string)$id === request('category'))>{{ $name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-6 col-md-3">
          <select name="ingredient" class="form-select" data-choices>
            <option value="">Qualsiasi ingrediente</option>
            @foreach($filters['ingredients'] as $id => $name)
              <option value="{{ $id }}" @selected((string)$id === request('ingredient'))>{{ $name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-6 col-md-2">
          <select name="sort" class="form-select" data-choices>
            <option value="">Più recenti</option>
            <option value="name_asc" @selected(request('sort')==='name_asc')>Nome A→Z</option>
            <option value="name_desc" @selected(request('sort')==='name_desc')>Nome Z→A</option>
            <option value="price_asc" @selected(request('sort')==='price_asc')>Prezzo ↑</option>
            <option value="price_desc" @selected(request('sort')==='price_desc')>Prezzo ↓</option>
          </select>
        </div>
      </div>
      <div class="mt-3 d-flex gap-2">
        <button class="btn btn-outline-primary" type="submit">Filtra</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.pizzas.index') }}">Reset</a>
      </div>
    </div>
  </form>

  <div class="card">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Pizza</th>
            <th>Categoria</th>
            <th>Prezzo</th>
            <th class="text-end">Azioni</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pizzas as $p)
            <tr>
              <td>{{ $p->id }}</td>
              <td class="d-flex align-items-center gap-2">
                @if($p->image_path)
                  <img src="{{ asset('storage/'.$p->image_path) }}" alt="{{ $p->name }}" class="rounded" style="width:48px;height:48px;object-fit:cover;">
                @endif
                <div>
                  <a href="{{ route('admin.pizzas.show', $p) }}" class="fw-semibold text-decoration-none">{{ $p->name }}</a>
                  @if($p->description)
                    <div class="text-muted small">{{ \Illuminate\Support\Str::limit($p->description, 80) }}</div>
                  @endif
                </div>
              </td>
              <td>{{ $p->category?->name ?? '-' }}</td>
              <td>€ {{ number_format($p->price, 2, ',', '.') }}</td>
              <td class="text-end">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.pizzas.edit', $p) }}">Modifica</a>
                <form class="d-inline" method="POST" action="{{ route('admin.pizzas.destroy', $p) }}" data-confirm="Sicuro?">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" type="submit">Elimina</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Nessuna pizza trovata.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($pizzas->hasPages())
      <div class="card-footer">
        {{ $pizzas->links() }}
      </div>
    @endif
  </div>
</x-app-layout>
