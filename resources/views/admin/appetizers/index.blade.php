<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <h1 class="h4 mb-0">Antipasti</h1>
            <a class="btn btn-primary" href="{{ route('admin.appetizers.create') }}">+ Nuovo antipasto</a>
        </div>
    </x-slot>

    @include('partials.flash')

            <x-filter-toolbar
                search
                searchPlaceholder="Cerca per nome o descrizione…"
                :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A', 'price_asc' => 'Prezzo ↑', 'price_desc' => 'Prezzo ↓']"
                :reset-url="route('admin.appetizers.index')"
        />

            <div class="row g-3">
                @forelse($appetizers as $a)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 d-flex">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <a href="{{ route('admin.appetizers.show', $a) }}" class="fw-semibold text-decoration-none">{{ $a->name }}</a>
                                    
                                </div>
                                @if($a->description)
                                    <div class="text-muted small mb-2">{{ \Illuminate\Support\Str::limit($a->description, 80) }}</div>
                                @endif
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div class="fw-semibold">€ {{ number_format($a->price, 2, ',', '.') }}</div>
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.appetizers.edit', $a) }}">Modifica</a>
                                        <form class="d-inline" method="POST" action="{{ route('admin.appetizers.destroy', $a) }}" data-confirm="Sicuro?">
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
                        <div class="alert alert-info text-center mb-0">Nessun antipasto trovato.</div>
                    </div>
                @endforelse
            </div>

            @if($appetizers->hasPages())
                <div class="mt-3 d-flex justify-content-center">
                    {{ $appetizers->links() }}
                </div>
            @endif
</x-app-layout>
