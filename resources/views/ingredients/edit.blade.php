<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Modifica Ingrediente</h2>
    </x-slot>

    <div class="col-12 col-lg-6 mx-auto py-4">
    <form action="{{ route('admin.ingredients.update', $ingredient) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <x-input-label for="name" value="Nome" />
                <x-text-input id="name" name="name" type="text" class="form-control" value="{{ old('name', $ingredient->name) }}" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
            </div>
            <div class="mb-3">
                <x-input-label for="allergens" value="Allergeni" />
                <select id="allergens" name="allergens[]" multiple class="form-select" size="6">
                    @foreach ($allergens as $a)
                        <option value="{{ $a->id }}" @selected($ingredient->allergens->pluck('id')->contains($a->id))>{{ $a->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('allergens')" class="mt-2 text-danger" />
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.ingredients.index') }}" class="btn btn-outline-secondary">Annulla</a>
                <x-primary-button class="btn btn-primary">Salva</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
