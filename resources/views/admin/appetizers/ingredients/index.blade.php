<x-app-layout>
    <x-page-header title="Ingredienti" :items="[['label' => 'Ingredienti']]" />
    <div class="container py-4">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.ingredients.create') }}" class="btn btn-primary">Aggiungi ingrediente</a>
            @if (session('status'))
                <div class="text-success">{{ session('status') }}</div>
            @endif
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @forelse ($ingredients as $ingredient)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">
                                    <a href="{{ route('admin.ingredients.show', $ingredient) }}" class="stretched-link text-decoration-none">{{ $ingredient->name }}</a>
                                </h5>
                                @php($allergenCount = $ingredient->allergens->count())
                                @if($allergenCount > 0)
                                    <span class="badge bg-warning text-dark" 
                                          role="button"
                                          tabindex="0"
                                          title="{{ $allergenCount }} {{ \Illuminate\Support\Str::plural('allergene', $allergenCount) }} in questo ingrediente"
                                          aria-label="Contiene {{ $allergenCount }} {{ \Illuminate\Support\Str::plural('allergene', $allergenCount) }}">
                                      <i class="fas fa-exclamation-triangle me-1" aria-hidden="true"></i>{{ $allergenCount }}
                                    </span>
                                @endif
                            </div>
                            @php($names = $ingredient->allergens->pluck('name'))
                            @if($names->isNotEmpty())
                                <p class="card-text text-muted small mb-3">Allergeni: {{ $names->join(', ') }}</p>
                            @endif
                            <div class="mt-auto d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.ingredients.edit', $ingredient) }}" class="btn btn-outline-success btn-sm" style="border:1.5px solid #388e3c;color:#388e3c;background:transparent;">Modifica</a>
                                <form action="{{ route('admin.ingredients.destroy', $ingredient) }}" method="POST" data-confirm="Sicuro?">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" type="submit" style="border:1.5px solid #d32f2f;color:#d32f2f;background:transparent;">Elimina</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-info mb-0">Nessun ingrediente.</div>
                </div>
            @endforelse
        </div>

        <nav class="mt-4 d-flex justify-content-center" aria-label="Paginazione ingredienti">
            {{ $ingredients->links('pagination.custom') }}
        </nav>
    </div>
</x-app-layout>
