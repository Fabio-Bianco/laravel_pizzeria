<x-app-layout>
    <div class="col-12 col-lg-6 mx-auto py-4">
    <form action="{{ route('admin.ingredients.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
            @csrf
            <div class="mb-3">
                <x-input-label for="name" value="Nome" />
                <x-text-input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
            </div>
            <div class="mb-3">
                <x-input-label for="allergens" value="Allergeni" />
                <select id="allergens" name="allergens[]" multiple class="form-select" size="6">
                    @foreach ($allergens as $allergen)
                        <option value="{{ $allergen->id }}" @selected(collect(old('allergens', []))->contains($allergen->id))>{{ $allergen->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('allergens')" class="mt-2 text-danger" />
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.ingredients.index') }}" class="btn btn-outline-secondary">Annulla</a>
                <x-primary-button class="btn btn-primary">Crea</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
