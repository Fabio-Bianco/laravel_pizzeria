<x-app-layout>
    <x-page-header :title="$ingredient->name" :items="[['label' => 'Ingredienti', 'url' => route('admin.ingredients.index')], ['label' => $ingredient->name]]" :backUrl="route('admin.ingredients.index')" />

    <div class="row py-4">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nome</dt>
                        <dd class="col-sm-8">{{ $ingredient->name }}</dd>

                        <dt class="col-sm-4">Allergeni</dt>
                        <dd class="col-sm-8">
                            @php($names = $ingredient->allergens->pluck('name'))
                            {{ $names->isNotEmpty() ? $names->join(', ') : '-' }}
                        </dd>
                    </dl>
                </div>
                <div class="card-footer d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.ingredients.edit', $ingredient) }}" class="btn btn-warning">Modifica</a>
                    <form action="{{ route('admin.ingredients.destroy', $ingredient) }}" method="POST" data-confirm="Sicuro?">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Elimina</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
