<x-app-layout>
    <x-page-header title="Antipasti" :items="[['label' => 'Antipasti']]" />
    <div class="container py-4">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.appetizers.create') }}" class="btn btn-primary">Aggiungi antipasto</a>
            @if (session('status'))
                <div class="text-success">{{ session('status') }}</div>
            @endif
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @forelse ($appetizers as $appetizer)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">
                                    <a href="{{ route('admin.appetizers.show', $appetizer) }}" class="stretched-link text-decoration-none">{{ $appetizer->name }}</a>
                                </h5>
                            </div>
                            <p class="card-text fw-semibold">€ {{ number_format($appetizer->price, 2, ',', '.') }}</p>
                            @if($appetizer->description)
                                <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($appetizer->description, 120) }}</p>
                            @endif
                            <div class="mt-auto d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.appetizers.edit', $appetizer) }}" class="btn btn-sm btn-warning">Modifica</a>
                                <form action="{{ route('admin.appetizers.destroy', $appetizer) }}" method="POST" data-confirm="Sicuro?">
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
                    <div class="alert alert-info mb-0">Nessun antipasto.</div>
                </div>
            @endforelse
        </div>

        <nav class="mt-4 d-flex justify-content-center" aria-label="Paginazione antipasti">
            {{ $appetizers->links() }}
        </nav>
    </div>
</x-app-layout>
