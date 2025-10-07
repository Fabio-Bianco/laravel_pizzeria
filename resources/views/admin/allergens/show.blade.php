<x-app-layout>
    <x-page-header :title="$allergen->name" :items="[['label' => 'Allergeni', 'url' => route('admin.allergens.index')], ['label' => $allergen->name]]" :backUrl="route('admin.allergens.index')" />
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <p class="mb-0 text-muted">Questo allergene può essere associato a uno o più ingredienti.</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.allergens.edit', $allergen) }}" class="btn btn-success">Modifica</a>
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
