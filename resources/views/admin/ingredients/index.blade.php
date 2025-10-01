<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Ingredienti" :items="[['label' => 'Ingredienti']]">
            <x-slot name="actions">
                <a class="btn btn-primary" href="{{ route('admin.ingredients.create') }}">+ Nuovo ingrediente</a>
            </x-slot>
        </x-page-header>
    </x-slot>

    @include('partials.flash')

        <x-filter-toolbar
                search
                searchPlaceholder="Cerca per nome…"
                :selects="[
                        ['name' => 'allergen', 'placeholder' => 'Qualsiasi allergene', 'options' => ($filters['allergens'] ?? [])],
                ]"
                :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A']"
                :reset-url="route('admin.ingredients.index')"
        />

        <div class="row g-3">
            @forelse($ingredients as $ing)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 d-flex">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <a href="{{ route('admin.ingredients.show', $ing) }}" class="fw-semibold text-decoration-none">{{ $ing->name }}</a>
                                <div class="d-flex align-items-center gap-2">
                                    

                                </div>
                            </div>
                            @php($names = $ing->allergens->pluck('name'))
                            <div class="text-muted small mb-2">
                                <span class="fw-semibold">Allergeni:</span>
                                {{ $names->isNotEmpty() ? $names->join(', ') : '-' }}
                                <br>
                                 <span class="badge text-bg-info-subtle text-info-emphasis" title="Pizze che usano l'ingrediente">{{ $ing->pizzas_count }} pizze contengono questo ingrediente</span>
                            </div>
                            <div class="mt-auto d-flex justify-content-end gap-2">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.ingredients.edit', $ing) }}">Modifica</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.ingredients.destroy', $ing) }}" data-confirm="Sicuro?">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Elimina</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center mb-0">Nessun ingrediente trovato.</div>
                </div>
            @endforelse
        </div>

        @if($ingredients->hasPages())
            <div class="mt-3 d-flex justify-content-center">
                {{ $ingredients->links() }}
            </div>
        @endif
</x-app-layout>
