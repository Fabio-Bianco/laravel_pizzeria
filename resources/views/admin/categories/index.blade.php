<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Categorie" :items="[['label' => 'Categorie']]">
            <x-slot name="actions">
                <a class="btn btn-primary" href="{{ route('admin.categories.create') }}">+ Nuova categoria</a>
            </x-slot>
        </x-page-header>
    </x-slot>

    @include('partials.flash')

    <x-filter-toolbar
        search
        searchPlaceholder="Cerca per nome o descrizione…"
        :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A']"
        :reset-url="route('admin.categories.index')"
    />

    <div class="container py-4">


        <div class="list-container">
            @forelse ($categories as $category)
                <div class="d-flex align-items-center list-item-pizza">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h6 class="mb-0 text-truncate">
                                <a href="{{ route('admin.categories.show', $category) }}" class="text-decoration-none">{{ $category->name }}</a>
                            </h6>
                            <span class="badge badge-info" title="Numero pizze in categoria">{{ $category->pizzas_count }} pizze</span>
                        </div>
                        @if($category->description)
                            <div class="text-muted small mb-1">{{ \Illuminate\Support\Str::limit($category->description, 120) }}</div>
                        @endif
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-3 flex-shrink-0">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="btn btn-success btn-sm d-flex align-items-center gap-1"
                           title="Modifica categoria">
                            <i class="fas fa-edit me-1" aria-hidden="true"></i> <span>Modifica</span>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" data-confirm="Sicuro?" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm d-flex align-items-center gap-1" type="submit" title="Elimina categoria">
                                <i class="fas fa-trash me-1" aria-hidden="true"></i> <span>Elimina</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="alert alert-info mb-0">Nessuna categoria.</div>
            @endforelse
        </div>

        <nav class="mt-4 d-flex justify-content-center" aria-label="Paginazione categorie">
            {{ $categories->links('pagination.custom') }}
        </nav>
    </div>
</x-app-layout>
