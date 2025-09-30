<x-app-layout>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <p class="text-muted mb-0">Nessun dettaglio aggiuntivo.</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.allergens.edit', $allergen) }}" class="btn btn-warning">Modifica</a>
                    <form action="{{ route('admin.allergens.destroy', $allergen) }}" method="POST" data-confirm="Sicuro?">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Elimina</button>
                    </form>
                    <a href="{{ route('admin.allergens.index') }}" class="btn btn-outline-secondary">Torna all'elenco</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
