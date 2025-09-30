<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Categoria: {{ $category->name }}</h2>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        @if($category->description)
                            <p class="mb-0">{{ $category->description }}</p>
                        @else
                            <p class="text-muted mb-0">Nessuna descrizione.</p>
                        @endif
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">Modifica</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" data-confirm="Sicuro?">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Elimina</button>
                    </form>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Torna all'elenco</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
