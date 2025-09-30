<x-app-layout>
    <x-page-header :title="$ingredient->name" :items="[['label' => 'Ingredienti', 'url' => route('admin.ingredients.index')], ['label' => $ingredient->name]]" :backUrl="route('admin.ingredients.index')" />
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div>
                            <strong>Allergeni:</strong>
                            <ul class="mt-2">
                                @forelse ($ingredient->allergens as $allergen)
                                    <li>{{ $allergen->name }}</li>
                                @empty
                                    <li class="text-muted">Nessuno</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.ingredients.edit', $ingredient) }}" class="btn btn-warning">Modifica</a>
                    <form action="{{ route('admin.ingredients.destroy', $ingredient) }}" method="POST" data-confirm="Sicuro?">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Elimina</button>
                    </form>
                    <a href="{{ route('admin.ingredients.index') }}" class="btn btn-outline-secondary">Torna all'elenco</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
