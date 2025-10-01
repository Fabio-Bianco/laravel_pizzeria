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

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @forelse ($categories as $category)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="stretched-link text-decoration-none">{{ $category->name }}</a>
                                </h5>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge text-bg-info-subtle text-info-emphasis" title="Numero pizze in categoria">{{ $category->pizzas_count }} pizze</span>
                                </div>
                            </div>
                            @if($category->description)
                                <p class="card-text text-muted small mb-3">{{ \Illuminate\Support\Str::limit($category->description, 120) }}</p>
                            @endif
                            <div class="mt-auto d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">Modifica</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" data-confirm="Sicuro?">
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
                    <div class="alert alert-info mb-0">Nessuna categoria.</div>
                </div>
            @endforelse
        </div>

        <nav class="mt-4 d-flex justify-content-center" aria-label="Paginazione categorie">
            {{ $categories->links() }}
        </nav>
    </div>
</x-app-layout>
