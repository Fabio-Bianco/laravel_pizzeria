<x-app-layout>
    <x-page-header :title="'Modifica: ' . $appetizer->name" :items="[['label' => 'Antipasti', 'url' => route('admin.appetizers.index')], ['label' => $appetizer->name], ['label' => 'Modifica']]" :backUrl="route('admin.appetizers.index')" />
    <div class="row justify-content-center py-4">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <span class="h6 mb-0">Dettagli antipasto</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.appetizers.update', $appetizer) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $appetizer->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Prezzo</label>
                            <input id="price" name="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $appetizer->price) }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione</label>
                            <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $appetizer->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-secondary">Annulla</a>
                            <button type="submit" class="btn btn-primary">Salva</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
