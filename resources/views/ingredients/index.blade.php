<x-app-layout>
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
                            <h5 class="card-title mb-2">
                                <a href="{{ route('admin.ingredients.show', $ingredient) }}" class="stretched-link text-decoration-none">{{ $ingredient->name }}</a>
                            </h5>
                            @php($names = $ingredient->allergens->pluck('name'))
                            @if($names->isNotEmpty())
                                <p class="card-text text-muted small mb-3">Allergeni: {{ $names->join(', ') }}</p>
                            @endif
                            <div class="mt-auto d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.ingredients.edit', $ingredient) }}" class="btn btn-sm btn-warning">Modifica</a>
                                <form action="{{ route('admin.ingredients.destroy', $ingredient) }}" method="POST" data-confirm="Sicuro?">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Elimina</button>
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
            {{ $ingredients->links() }}
        </nav>
    </div>
</x-app-layout>
