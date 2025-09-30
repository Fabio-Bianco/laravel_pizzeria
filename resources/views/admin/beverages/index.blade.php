<x-app-layout>
    <x-page-header title="Bevande" :items="[['label' => 'Bevande']]" />
    <div class="container py-4">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.beverages.create') }}" class="btn btn-primary">Aggiungi bevanda</a>
            @if (session('status'))
                <div class="text-success">{{ session('status') }}</div>
            @endif
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @forelse ($beverages as $beverage)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">
                                    <a href="{{ route('admin.beverages.show', $beverage) }}" class="stretched-link text-decoration-none">{{ $beverage->name }}</a>
                                </h5>
                            </div>
                            <p class="card-text fw-semibold">€ {{ number_format($beverage->price, 2, ',', '.') }}</p>
                            @if($beverage->description)
                                <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($beverage->description, 120) }}</p>
                            @endif
                            <div class="mt-auto d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.beverages.edit', $beverage) }}" class="btn btn-sm btn-warning">Modifica</a>
                                <form action="{{ route('admin.beverages.destroy', $beverage) }}" method="POST" data-confirm="Sicuro?">
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
                    <div class="alert alert-info mb-0">Nessuna bevanda.</div>
                </div>
            @endforelse
        </div>

        <nav class="mt-4 d-flex justify-content-center" aria-label="Paginazione bevande">
            {{ $beverages->links() }}
        </nav>
    </div>
</x-app-layout>
