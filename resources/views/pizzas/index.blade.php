<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pizze</h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.pizzas.create') }}" class="btn btn-primary">Aggiungi pizza</a>
            @if (session('status'))
                <div class="text-success">{{ session('status') }}</div>
            @endif
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @forelse ($pizzas as $pizza)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">
                                    <a href="{{ route('admin.pizzas.show', $pizza) }}" class="stretched-link text-decoration-none">{{ $pizza->name }}</a>
                                </h5>
                                <span class="badge text-bg-secondary">{{ optional($pizza->category)->name ?? '-' }}</span>
                            </div>
                            <p class="card-text fw-semibold">€ {{ number_format($pizza->price, 2, ',', '.') }}</p>
                            @if($pizza->description)
                                <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($pizza->description, 120) }}</p>
                            @endif
                            <div class="mt-auto d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.pizzas.edit', $pizza) }}" class="btn btn-sm btn-warning">Modifica</a>
                                <form action="{{ route('admin.pizzas.destroy', $pizza) }}" method="POST" onsubmit="return confirm('Sicuro?')">
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
                    <div class="alert alert-info mb-0">Nessuna pizza.</div>
                </div>
            @endforelse
        </div>

        <nav class="mt-4 d-flex justify-content-center" aria-label="Paginazione pizze">
            {{ $pizzas->links() }}
        </nav>
    </div>
</x-app-layout>
