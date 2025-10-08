<x-app-layout>
    <x-page-header title="Allergeni" :items="[['label' => 'Allergeni']]" />
    <div class="container py-4">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.allergens.create') }}" class="btn btn-primary">Aggiungi allergene</a>
            @if (session('status'))
                <div class="text-success">{{ session('status') }}</div>
            @endif
        </div>


        <div class="list-container">
            @forelse ($allergens as $allergen)
                <div class="d-flex align-items-center list-item-pizza">
                    <div class="flex-grow-1">
                        <h6 class="mb-0 text-truncate">{{ $allergen->name }}</h6>
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-3 flex-shrink-0">
                        <a href="{{ route('admin.allergens.edit', $allergen) }}"
                           class="btn btn-success btn-sm d-flex align-items-center gap-1"
                           title="Modifica allergene">
                            <i class="fas fa-edit me-1" aria-hidden="true"></i> <span>Modifica</span>
                        </a>
                        <form action="{{ route('admin.allergens.destroy', $allergen) }}" method="POST" data-confirm="Sicuro?" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm d-flex align-items-center gap-1" type="submit" title="Elimina allergene">
                                <i class="fas fa-trash me-1" aria-hidden="true"></i> <span>Elimina</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="alert alert-info mb-0">Nessun allergene.</div>
            @endforelse
        </div>

        <nav class="mt-4 d-flex justify-content-center" aria-label="Paginazione allergeni">
            {{ $allergens->links('pagination.custom') }}
        </nav>
    </div>
</x-app-layout>
