<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Categorie</h2>
    </x-slot>

    <div class="container py-4">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Aggiungi categoria</a>
            @if (session('status'))
                <div class="alert alert-success mb-0 py-1 px-2">{{ session('status') }}</div>
            @endif
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @forelse ($categories as $category)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2">
                                <a href="{{ route('admin.categories.show', $category) }}" class="stretched-link text-decoration-none">{{ $category->name }}</a>
                            </h5>
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
