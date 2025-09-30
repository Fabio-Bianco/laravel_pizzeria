<x-app-layout>
    <div class="container py-4">
        <div class="d-flex align-items-center mb-3">
            <x-back-link :href="route('admin.pizzas.index')" />
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <p class="mb-1"><strong>Categoria:</strong> {{ optional($pizza->category)->name ?? '-' }}</p>
                        <p class="mb-1"><strong>Prezzo:</strong> € {{ number_format($pizza->price, 2, ',', '.') }}</p>
                        @if($pizza->description)
                          <p class="mb-3">{{ $pizza->description }}</p>
                        @endif
                        <div class="mt-3">
                            <strong>Ingredienti:</strong>
                            <ul class="mt-2">
                                @forelse ($pizza->ingredients as $i)
                                    <li>{{ $i->name }}</li>
                                @empty
                                    <li class="text-muted">Nessuno</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pizzas.edit', $pizza) }}" class="btn btn-warning">Modifica</a>
                    <form action="{{ route('admin.pizzas.destroy', $pizza) }}" method="POST" data-confirm="Sicuro?">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Elimina</button>
                    </form>
                    <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-secondary">Torna all'elenco</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
