<x-app-layout>
<x-page-header :title="'Modifica: ' . $allergen->name" :items="[['label' => 'Allergeni', 'url' => route('admin.allergens.index')], ['label' => $allergen->name], ['label' => 'Modifica']]" :backUrl="route('admin.allergens.index')" />
<div class="row justify-content-center py-4">
    <div class="col-12 col-lg-8 col-xl-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <span class="h6 mb-0">Dettagli allergene</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.allergens.update', $allergen) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $allergen->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.allergens.index') }}" class="btn btn-outline-secondary">Annulla</a>
                        <button type="submit" class="btn btn-primary">Salva</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
