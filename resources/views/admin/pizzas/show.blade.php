<x-app-layout>
  <x-slot name="header">
    <x-page-header :title="$pizza->name" :items="[['label'=>'Pizze','url'=>route('admin.pizzas.index')],['label'=>$pizza->name]]" :backUrl="route('admin.pizzas.index')" />
  </x-slot>

  <div class="container py-3">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-8">
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <div class="d-flex gap-3 align-items-start">
              @if($pizza->image_path)
                <img src="{{ asset('storage/'.$pizza->image_path) }}" alt="{{ $pizza->name }}" class="rounded" style="width:140px;height:140px;object-fit:cover;">
              @endif
              <div>
                <p class="mb-1"><strong>Categoria:</strong> {{ $pizza->category?->name ?? '-' }}</p>
                <p class="mb-1"><strong>Prezzo:</strong> € {{ number_format($pizza->price, 2, ',', '.') }}</p>
                @if($pizza->description)
                  <p class="mb-2">{{ $pizza->description }}</p>
                @endif
                <div class="mt-2">
                  <strong>Ingredienti:</strong>
                  <ul class="mt-2">
                    @forelse ($pizza->ingredients as $ingredient)
                      <li>{{ $ingredient->name }}</li>
                    @empty
                      <li class="text-muted">Nessuno</li>
                    @endforelse
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex gap-2">
          <a href="{{ route('admin.pizzas.edit', $pizza) }}" class="btn btn-warning">Modifica</a>
          <form action="{{ route('admin.pizzas.destroy', $pizza) }}" method="POST" data-confirm="Sicuro?">
            @csrf @method('DELETE')
            <button class="btn btn-danger" type="submit">Elimina</button>
          </form>
          <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-secondary">Torna all'elenco</a>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
