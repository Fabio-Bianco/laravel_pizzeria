<x-app-layout>
    <x-page-header :title="$appetizer->name" :items="[['label' => 'Antipasti', 'url' => route('admin.appetizers.index')], ['label' => $appetizer->name]]" :backUrl="route('admin.appetizers.index')" />
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <p class="mb-1"><strong>Prezzo:</strong> € {{ number_format($appetizer->price, 2, ',', '.') }}</p>
                        @if($appetizer->description)
                          <p class="mb-3">{{ $appetizer->description }}</p>
                        @endif
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.appetizers.edit', $appetizer) }}" class="btn btn-warning">Modifica</a>
                    <form action="{{ route('admin.appetizers.destroy', $appetizer) }}" method="POST" data-confirm="Sicuro?">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Elimina</button>
                    </form>
                    <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-secondary">Torna all'elenco</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
