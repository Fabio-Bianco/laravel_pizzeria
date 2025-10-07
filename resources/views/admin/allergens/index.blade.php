<x-app-layout>
    <x-page-header title="Allergeni" :items="[['label' => 'Allergeni']]" />
    <div class="container py-4">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.allergens.create') }}" class="btn btn-primary">Aggiungi allergene</a>
            @if (session('status'))
                <div class="text-success">{{ session('status') }}</div>
            @endif
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @forelse ($allergens as $allergen)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2">
                                <a href="{{ route('admin.allergens.show', $allergen) }}" class="stretched-link text-decoration-none">{{ $allergen->name }}</a>
                            </h5>
                            <div class="mt-auto d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.allergens.edit', $allergen) }}" class="btn btn-sm btn-success">Modifica</a>
                                <form action="{{ route('admin.allergens.destroy', $allergen) }}" method="POST" data-confirm="Sicuro?">
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
                    <div class="alert alert-info mb-0">Nessun allergene.</div>
                </div>
            @endforelse
        </div>

        <nav class="mt-4 d-flex justify-content-center" aria-label="Paginazione allergeni">
            {{ $allergens->links('pagination.custom') }}
        </nav>
    </div>
</x-app-layout>
