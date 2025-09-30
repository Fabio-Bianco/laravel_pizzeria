<x-app-layout>
    <x-page-header :title="'Modifica: ' . $beverage->name" :items="[['label' => 'Bevande', 'url' => route('admin.beverages.index')], ['label' => $beverage->name], ['label' => 'Modifica']]" :backUrl="route('admin.beverages.index')" />
    <div class="row justify-content-center py-4">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <span class="h6 mb-0">Dettagli bevanda</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.beverages.update', $beverage) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $beverage->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Prezzo</label>
                            <input id="price" name="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $beverage->price) }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione</label>
                            <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $beverage->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.beverages.index') }}" class="btn btn-outline-secondary">Annulla</a>
                            <button type="submit" class="btn btn-primary">Salva</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
