<x-app-layout>
    <x-page-header title="Nuovo ingrediente" :items="[['label' => 'Ingredienti', 'url' => route('admin.ingredients.index')], ['label' => 'Nuovo']]" :backUrl="route('admin.ingredients.index')" />
    <div class="col-12 col-lg-6 mx-auto py-4">
        <form action="{{ route('admin.ingredients.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="allergens" class="form-label">Allergeni</label>
                <select id="allergens" name="allergens[]" multiple class="form-select" data-choices>
                    @foreach ($allergens as $a)
                        <option value="{{ $a->id }}">{{ $a->name }}</option>
                    @endforeach
                </select>
                @error('allergens')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.ingredients.index') }}" class="btn btn-outline-secondary">Annulla</a>
                <button type="submit" class="btn btn-primary">Crea</button>
            </div>
        </form>
    </div>
</x-app-layout>
