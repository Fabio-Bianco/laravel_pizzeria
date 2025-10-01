<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Bevande" :items="[['label' => 'Bevande']]">
            <x-slot name="actions">
                <a class="btn btn-primary" href="{{ route('admin.beverages.create') }}">+ Nuova bevanda</a>
            </x-slot>
        </x-page-header>
    </x-slot>

    @include('partials.flash')

            <x-filter-toolbar
                search
                searchPlaceholder="Cerca per nome o descrizione…"
                :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A', 'price_asc' => 'Prezzo ↑', 'price_desc' => 'Prezzo ↓']"
                :reset-url="route('admin.beverages.index')"
        />

            <div class="row g-3">
                @forelse($beverages as $b)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 d-flex">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <a href="{{ route('admin.beverages.show', $b) }}" class="fw-semibold text-decoration-none">{{ $b->name }}</a>
                                   
                                </div>
                                @if($b->description)
                                    <div class="text-muted small mb-2">{{ \Illuminate\Support\Str::limit($b->description, 80) }}</div>
                                @endif
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div class="fw-semibold">€ {{ number_format($b->price, 2, ',', '.') }}</div>
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.beverages.edit', $b) }}">Modifica</a>
                                        <form class="d-inline" method="POST" action="{{ route('admin.beverages.destroy', $b) }}" data-confirm="Sicuro?">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Elimina</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center mb-0">Nessuna bevanda trovata.</div>
                    </div>
                @endforelse
            </div>

            @if($beverages->hasPages())
                <div class="mt-3 d-flex justify-content-center">
                    {{ $beverages->links() }}
                </div>
            @endif
</x-app-layout>
